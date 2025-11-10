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

            // Get real-time maintenance alerts - recalculated on every page load
            $maintenanceAlerts = $this->getRealTimeMaintenanceAlerts();

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

/**
 * Get real-time maintenance alerts that recalculate on every page load - FIXED VERSION
 */
private function getRealTimeMaintenanceAlerts()
{
    $maintenanceAlerts = collect();

    $activeCustomersList = Customer::where('status', 'active')->get();

    foreach ($activeCustomersList as $customer) {
        if (!$customer->hasContractExpired()) {
            // Force fresh calculation by reloading relationships
            $customer->load('maintenanceHistory');
            $customer->recalculateMaintenanceDates();

            // Get ALL maintenance alerts for this customer, not just the most urgent one
            $allAlerts = $customer->getAllMaintenanceAlertDates();

            foreach ($allAlerts as $alert) {
                // Check if this alert date is already completed
                if (!$customer->isMaintenanceDateCompleted($alert['date'])) {
                    $maintenanceAlerts->push([
                        'customer' => $customer,
                        'alert' => $alert
                    ]);
                }
            }
        }
    }

    // Sort by urgency (overdue first, then by days)
    return $maintenanceAlerts->sortBy(function($item) {
        // Overdue come first (negative days), then sort by absolute days
        if ($item['alert']['type'] === 'overdue') {
            return $item['alert']['days']; // Most negative (oldest) first
        } else {
            return 10000 + $item['alert']['days']; // Upcoming after overdue
        }
    });
}
}
