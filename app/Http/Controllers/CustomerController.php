<?php
// app/Http/Controllers/CustomerController.php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MaintenanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('customer_id', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }
        
        $customers = $query->latest()->paginate(10);
        
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
            'service_type' => 'required|in:baiting_system_complete,baiting_system_not_complete,host_system',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'comments' => 'nullable|string',
        ]);

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
            'address' => 'required|string',
            'google_map_link' => 'nullable|url',
            'phone_number' => 'required|string',
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_type' => 'required|in:baiting_system_complete,baiting_system_not_complete,host_system',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date|after:contract_start_date',
            'comments' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
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

        return redirect()->back()->with('success', 'Maintenance recorded successfully.');
    }

    public function renewContract(Request $request, Customer $customer)
    {
        $request->validate([
            'contract_end_date' => 'required|date|after:today',
            'service_type' => 'required|in:baiting_system_complete,baiting_system_not_complete,host_system',
            'service_price' => 'required|numeric|min:0',
        ]);

        $customer->update([
            'contract_end_date' => $request->contract_end_date,
            'service_type' => $request->service_type,
            'service_price' => $request->service_price,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Contract renewed successfully.');
    }
}