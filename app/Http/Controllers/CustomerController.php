<?php
// app/Http/Controllers/CustomerController.php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MaintenanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('customer_id', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Service type filter
        if ($request->has('service_type') && $request->service_type != '') {
            $query->where('service_type', $request->service_type);
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Contract status filter
        if ($request->has('contract_status') && $request->contract_status != '') {
            $today = Carbon::today();

            if ($request->contract_status === 'active') {
                $query->where('status', 'active')
                      ->where('contract_end_date', '>=', $today);
            } elseif ($request->contract_status === 'expiring') {
                $query->where('status', 'active')
                      ->where('contract_end_date', '<=', $today->copy()->addDays(90))
                      ->where('contract_end_date', '>=', $today);
            } elseif ($request->contract_status === 'expired') {
                $query->where(function($q) use ($today) {
                    $q->where('contract_end_date', '<', $today)
                      ->orWhere('status', 'expired');
                });
            }
        }

        // Maintenance due filter
        if ($request->has('maintenance_due') && $request->maintenance_due == '1') {
            $query->whereHas('maintenanceHistory', function($q) {
                $q->where('maintenance_date', '<=', Carbon::today()->subDays(90));
            })->orWhereDoesntHave('maintenanceHistory');
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        // Validate sortable columns
        $sortableColumns = ['name', 'customer_id', 'service_type', 'contract_end_date', 'created_at'];
        if (!in_array($sort, $sortableColumns)) {
            $sort = 'created_at';
        }

        $query->orderBy($sort, $order);

        $customers = $query->paginate(15);

        // AJAX request - return JSON for just the list and pagination
        if ($request->ajax()) {
            $view = view('customers.partials.customer_list', compact('customers'))->render();
            $pagination = view('customers.partials.pagination', compact('customers'))->render();

            return response()->json([
                'success' => true,
                'html' => $view,
                'pagination' => $pagination,
                'count' => $customers->total(),
                'firstItem' => $customers->firstItem(),
                'lastItem' => $customers->lastItem(),
                'hasPages' => $customers->hasPages()
            ]);
        }

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'google_map_link' => 'nullable|url',
            'phone_number' => 'required|string',
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_type' => 'required|in:baiting_system_complete,baiting_system_not_complete,host_system,drill_injection',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'comments' => 'nullable|string',
        ]);

        $validated['status'] = 'active';
        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $maintenanceHistory = $customer->maintenanceHistory()->latest()->get();
        return view('customers.show', compact('customer', 'maintenanceHistory'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'google_map_link' => 'nullable|url',
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_type' => 'required|string',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'status' => 'required|in:active,pending',
            'comments' => 'nullable|string',
        ]);

        DB::table('customers')
            ->where('id', $customer->id)
            ->update($validated);

        $customer->refresh();
        return redirect()->route('customers.show', [$customer, 't' => time()])
            ->with('success', 'Customer updated successfully!');
    }

    public function markMaintenance(Request $request, Customer $customer)
    {
        $request->validate([
            'maintenance_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        MaintenanceHistory::create([
            'customer_id' => $customer->id,
            'maintenance_date' => $request->maintenance_date,
            'service_type' => $customer->service_type,
            'notes' => $request->notes,
            'performed_by' => Auth::user()->name,
        ]);

        $customer->refresh();
        $customer->recalculateMaintenanceDates();

        return redirect()->back()->with('success', 'Maintenance recorded successfully. Dashboard will update immediately.');
    }

public function renewContract(Request $request, Customer $customer)
{
    $request->validate([
        'contract_start_date' => 'required|date',
        'contract_end_date' => 'required|date|after:contract_start_date',
        'service_type' => 'required|in:baiting_system_complete,baiting_system_not_complete,host_system,drill_injection',
        'service_price' => 'required|numeric|min:0',
    ]);

    $customer->update([
        'contract_start_date' => $request->contract_start_date,
        'contract_end_date' => $request->contract_end_date,
        'service_type' => $request->service_type,
        'service_price' => $request->service_price,
        'status' => 'active',
    ]);

    return redirect()->back()->with('success', 'Contract renewed successfully.');
}

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
