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
            $expiringContracts = Customer::where('contract_end_date', '<=', now()->addDays(90))
                ->where('status', 'active')
                ->count();
            
            // Maintenance alerts - handle potential errors
            $maintenanceAlerts = Customer::where('status', 'active')->get()->filter(function($customer) {
                try {
                    return $customer->isMaintenanceDue();
                } catch (\Exception $e) {
                    return false;
                }
            });

            // Contract expiration alerts
            $contractAlerts = Customer::where('status', 'active')
                ->where('contract_end_date', '<=', now()->addDays(90))
                ->where('contract_end_date', '>=', now())
                ->get();

            // Recent maintenance with error handling
            $recentMaintenance = MaintenanceHistory::with('customer')
                ->latest()
                ->take(10)
                ->get();

            return view('dashboard', compact(
                'totalCustomers', 
                'activeCustomers', 
                'expiringContracts',
                'maintenanceAlerts',
                'contractAlerts',
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
                'recentMaintenance' => collect(),
            ]);
        }
    }
}