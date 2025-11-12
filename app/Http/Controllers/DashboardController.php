<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MaintenanceHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

        Log::info('Total active customers found: ' . $activeCustomers->count());

        foreach ($activeCustomers as $customer) {
            try {
                Log::info("Processing customer: {$customer->name} (ID: {$customer->id})");

                // Get ALL maintenance dates, not just the next one
                $allMaintenanceDates = $this->getAllMaintenanceDatesForCustomer($customer);
                Log::info("Customer {$customer->name} total maintenance dates found: " . count($allMaintenanceDates));

                $today = Carbon::today();
                $hasAddedUpcoming = false;

                foreach ($allMaintenanceDates as $maintenanceDate) {
                    $daysDifference = $today->diffInDays($maintenanceDate, false);
                    Log::info("Customer {$customer->name} date: {$maintenanceDate->format('Y-m-d')}, days difference: {$daysDifference}");

                    $isCompleted = $customer->isMaintenanceDateCompleted($maintenanceDate);
                    Log::info("Customer {$customer->name} maintenance completed for {$maintenanceDate->format('Y-m-d')}: " . ($isCompleted ? 'Yes' : 'No'));

                    // Skip completed maintenance
                    if ($isCompleted) {
                        continue;
                    }

                    // Add ALL overdue dates (any negative days)
                    if ($daysDifference < 0) {
                        $maintenanceAlerts->push([
                            'customer' => $customer,
                            'alert' => [
                                'date' => $maintenanceDate,
                                'days' => $daysDifference,
                                'type' => 'overdue'
                            ]
                        ]);
                        Log::info("Added OVERDUE alert for customer {$customer->name} for date {$maintenanceDate->format('Y-m-d')}");
                    }
                    // Add only the NEXT upcoming date within 7 days (not already added one)
                    elseif ($daysDifference <= 7 && $daysDifference >= 0 && !$hasAddedUpcoming) {
                        $maintenanceAlerts->push([
                            'customer' => $customer,
                            'alert' => [
                                'date' => $maintenanceDate,
                                'days' => $daysDifference,
                                'type' => $daysDifference == 0 ? 'today' : 'upcoming'
                            ]
                        ]);
                        $hasAddedUpcoming = true; // Only add one upcoming per customer
                        Log::info("Added UPCOMING alert for customer {$customer->name} for date {$maintenanceDate->format('Y-m-d')}");
                    }
                }

            } catch (\Exception $e) {
                Log::error("Error processing maintenance alerts for customer {$customer->id}: " . $e->getMessage());
                continue;
            }
        }

        Log::info('Total maintenance alerts found: ' . $maintenanceAlerts->count());

        // Sort by urgency: most overdue first, then due today, then upcoming
        return $maintenanceAlerts->sortBy(function($item) {
            /** @var array $item */
            $alert = $item['alert'] ?? [];
            $days = $alert['days'] ?? 0;

            if ($days < 0) {
                // Most overdue first (lowest negative number)
                return $days;
            } elseif ($days == 0) {
                // Due today comes after overdue
                return 10000;
            } else {
                // Upcoming: soonest first, but after overdue and due today
                return 20000 + $days;
            }
        })->values();
    }

    /**
     * Get ALL maintenance dates for a customer (overdue and future)
     */
    private function getAllMaintenanceDatesForCustomer(Customer $customer)
    {
        $dates = collect();
        $today = Carbon::today();

        // Get the last maintenance date or use contract start date
        $lastMaintenance = $customer->maintenanceHistory()->latest()->first();
        $startDate = $lastMaintenance ? $lastMaintenance->maintenance_date : $customer->contract_start_date;

        // Determine interval based on service type
        $intervalMonths = $customer->getMaintenanceInterval();

        // Calculate enough dates to cover from contract start to today + 30 days
        $earliestDate = $customer->contract_start_date->copy();
        $maxDate = $today->copy()->addDays(30);

        $currentDate = $earliestDate->copy();
        while ($currentDate <= $maxDate) {
            $dates->push($currentDate->copy());
            $currentDate = $currentDate->copy()->addMonths($intervalMonths);
        }

        // Filter to only include dates that are either overdue or within 7 days
        return $dates->filter(function($date) use ($today) {
            $daysDifference = $today->diffInDays($date, false);
            return $daysDifference < 0 || $daysDifference <= 7;
        })->sort()->values();
    }

    /**
     * API endpoint for dashboard stats (optional - for AJAX updates)
     */
    public function getStats()
    {
        try {
            $this->updateAllCustomerStatuses();

            // Get maintenance alerts and count them
            $maintenanceAlerts = $this->getRealTimeMaintenanceAlerts();
            $maintenanceAlertsCount = $maintenanceAlerts->count();

            // Calculate ALL counts separately
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
