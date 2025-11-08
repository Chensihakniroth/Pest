<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MaintenanceHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalCustomers = Customer::count();
            $activeCustomers = Customer::where('status', 'active')->count();

            // Fixed: Get expiring contracts (within 90 days, not expired)
            $expiringContracts = Customer::where('status', 'active')
                ->where('contract_end_date', '<=', Carbon::today()->addDays(90))
                ->where('contract_end_date', '>=', Carbon::today())
                ->count();

            // Maintenance alerts - ONLY for active customers (not expired)
            $maintenanceAlerts = Customer::where('status', 'active')->get()->filter(function($customer) {
                try {
                    // Only show maintenance alerts for active, non-expired contracts
                    return !$customer->hasContractExpired() && $customer->isMaintenanceDue();
                } catch (\Exception $e) {
                    return false;
                }
            });

            // Contract expiration alerts - only active contracts within 90 days
            $contractAlerts = Customer::where('status', 'active')
                ->where('contract_end_date', '<=', Carbon::today()->addDays(90))
                ->where('contract_end_date', '>=', Carbon::today())
                ->orderBy('contract_end_date', 'asc')
                ->get();

            // Expired contracts - separate display
            $expiredContracts = Customer::where(function($query) {
                $query->where('contract_end_date', '<', Carbon::today())
                      ->orWhere('status', 'expired');
            })->orderBy('contract_end_date', 'desc')
              ->get();

            // Recent maintenance - only for active customers
            $recentMaintenance = MaintenanceHistory::with(['customer' => function($query) {
                $query->where('status', 'active'); // Only show maintenance for active customers
            }])->whereHas('customer', function($query) {
                $query->where('status', 'active');
            })->latest()
              ->take(10)
              ->get();

            return view('dashboard', compact(
                'totalCustomers',
                'activeCustomers',
                'expiringContracts',
                'maintenanceAlerts',
                'contractAlerts',
                'expiredContracts',
                'recentMaintenance'
            ));

        } catch (\Exception $e) {
            // Return a basic dashboard if there are errors
            return view('dashboard', [
                'totalCustomers' => 0,
                'activeCustomers' => 0,
                'expiringContracts' => 0,
                'maintenanceAlerts' => collect(),
                'contractAlerts' => collect(),
                'expiredContracts' => collect(),
                'recentMaintenance' => collect(),
            ]);
        }
    }
}
