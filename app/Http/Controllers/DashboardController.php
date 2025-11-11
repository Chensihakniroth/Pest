<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MaintenanceHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Force status updates for all customers before counting
            $this->updateAllCustomerStatuses();

            $totalCustomers = Customer::count();

            // Get active customers (not expired and status active)
            $activeCustomers = Customer::where('status', 'active')
                ->where('contract_end_date', '>=', Carbon::today())
                ->count();

            // Get expiring contracts (active contracts within 90 days)
            $expiringContracts = Customer::where('status', 'active')
                ->where('contract_end_date', '>=', Carbon::today())
                ->where('contract_end_date', '<=', Carbon::today()->addDays(90))
                ->count();

            // Get real-time maintenance alerts - recalculated on every page load
            $maintenanceAlerts = $this->getRealTimeMaintenanceAlerts();
            $maintenanceAlertsCount = $maintenanceAlerts->count();

            // Contract expiration alerts - only active contracts within 90 days
            $contractAlerts = Customer::where('status', 'active')
                ->where('contract_end_date', '>=', Carbon::today())
                ->where('contract_end_date', '<=', Carbon::today()->addDays(90))
                ->orderBy('contract_end_date', 'asc')
                ->get();
            $contractAlertsCount = $contractAlerts->count();

            // Expired contracts - contracts that ended yesterday or earlier OR status expired
            $expiredContracts = Customer::where(function($query) {
                $query->where('contract_end_date', '<', Carbon::today())
                      ->orWhere('status', 'expired');
            })
            ->orderBy('contract_end_date', 'desc')
            ->get();
            $expiredContractsCount = $expiredContracts->count();

            // Recent maintenance - only for active customers
            $recentMaintenance = MaintenanceHistory::with(['customer' => function($query) {
                $query->where('status', 'active');
            }])->whereHas('customer', function($query) {
                $query->where('status', 'active');
            })->latest()
              ->take(10)
              ->get();

            // Debug info for development
            if (app()->environment('local')) {
                Log::info('Dashboard Stats', [
                    'total_customers' => $totalCustomers,
                    'active_customers' => $activeCustomers,
                    'expiring_contracts' => $expiringContracts,
                    'maintenance_alerts_count' => $maintenanceAlertsCount,
                    'contract_alerts_count' => $contractAlertsCount,
                    'expired_contracts_count' => $expiredContractsCount
                ]);
            }

            // Use array instead of compact to avoid IDE errors
            return view('dashboard', [
                'totalCustomers' => $totalCustomers,
                'activeCustomers' => $activeCustomers,
                'expiringContracts' => $expiringContracts,
                'maintenanceAlerts' => $maintenanceAlerts,
                'maintenanceAlertsCount' => $maintenanceAlertsCount,
                'contractAlerts' => $contractAlerts,
                'contractAlertsCount' => $contractAlertsCount,
                'expiredContracts' => $expiredContracts,
                'expiredContractsCount' => $expiredContractsCount,
                'recentMaintenance' => $recentMaintenance
            ]);

        } catch (\Exception $e) {
            Log::error('Dashboard Error: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            // Return a basic dashboard if there are errors
            return view('dashboard', [
                'totalCustomers' => Customer::count(),
                'activeCustomers' => 0,
                'expiringContracts' => 0,
                'maintenanceAlerts' => collect(),
                'maintenanceAlertsCount' => 0,
                'contractAlerts' => collect(),
                'contractAlertsCount' => 0,
                'expiredContracts' => collect(),
                'expiredContractsCount' => 0,
                'recentMaintenance' => collect(),
            ]);
        }
    }

    /**
     * Update all customer statuses based on contract dates
     */
    private function updateAllCustomerStatuses()
    {
        try {
            $customers = Customer::all();

            foreach ($customers as $customer) {
                $originalStatus = $customer->status;
                $customer->updateContractStatus();

                // Only save if status changed
                if ($customer->isDirty('status')) {
                    $customer->save();

                    if (app()->environment('local')) {
                        Log::info('Customer status updated', [
                            'customer_id' => $customer->id,
                            'customer_name' => $customer->name,
                            'old_status' => $originalStatus,
                            'new_status' => $customer->status,
                            'contract_end' => $customer->contract_end_date
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error updating customer statuses: ' . $e->getMessage());
        }
    }

    /**
     * Get real-time maintenance alerts that recalculate on every page load
     */
    private function getRealTimeMaintenanceAlerts()
    {
        $maintenanceAlerts = collect();

        // Get only active customers with valid contracts
        $activeCustomers = Customer::where('status', 'active')
            ->where('contract_end_date', '>=', Carbon::today())
            ->with('maintenanceHistory')
            ->get();

        foreach ($activeCustomers as $customer) {
            try {
                // Force fresh calculation
                $customer->recalculateMaintenanceDates();

                // Get the most urgent maintenance alert for this customer
                $urgentAlert = $customer->getMostUrgentMaintenanceAlert();

                if ($urgentAlert && !$customer->isMaintenanceDateCompleted($urgentAlert['date'])) {
                    $maintenanceAlerts->push([
                        'customer' => $customer,
                        'alert' => $urgentAlert
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("Error processing maintenance alerts for customer {$customer->id}: " . $e->getMessage());
                continue;
            }
        }

        // Sort by urgency: overdue first (most overdue first), then upcoming (soonest first)
        return $maintenanceAlerts->sortBy(function($item) {
            $alert = $item['alert'];

            if ($alert['type'] === 'overdue') {
                // Most negative days (oldest overdue) first
                return $alert['days'];
            } else {
                // Upcoming: soonest first (lowest positive number)
                return 10000 + $alert['days'];
            }
        })->values(); // Reset keys
    }

    /**
     * API endpoint for dashboard stats (optional - for AJAX updates)
     */
    public function getStats()
    {
        try {
            $this->updateAllCustomerStatuses();

            // Get maintenance alerts and count them manually to avoid count() method
            $maintenanceAlerts = $this->getRealTimeMaintenanceAlerts();
            $maintenanceAlertsCount = 0;
            foreach ($maintenanceAlerts as $alert) {
                $maintenanceAlertsCount++;
            }

            // Calculate ALL counts separately to avoid IDE errors
            $totalCustomersCount = Customer::count();
            $activeCustomersCount = Customer::where('status', 'active')
                ->where('contract_end_date', '>=', Carbon::today())
                ->count();
            $expiringContractsCount = Customer::where('status', 'active')
                ->where('contract_end_date', '>=', Carbon::today())
                ->where('contract_end_date', '<=', Carbon::today()->addDays(90))
                ->count();
            $contractAlertsCount = Customer::where('status', 'active')
                ->where('contract_end_date', '>=', Carbon::today())
                ->where('contract_end_date', '<=', Carbon::today()->addDays(90))
                ->count();
            $expiredContractsCount = Customer::where(function($query) {
                $query->where('contract_end_date', '<', Carbon::today())
                      ->orWhere('status', 'expired');
            })->count();

            $stats = [
                'totalCustomers' => $totalCustomersCount,
                'activeCustomers' => $activeCustomersCount,
                'expiringContracts' => $expiringContractsCount,
                'maintenanceAlertsCount' => $maintenanceAlertsCount,
                'contractAlertsCount' => $contractAlertsCount,
                'expiredContractsCount' => $expiredContractsCount,
                'lastUpdated' => now()->toDateTimeString()
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('Dashboard stats API error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch stats'], 500);
        }
    }
}
