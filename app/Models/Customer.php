<?php
// app/Models/Customer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'name', 'address', 'google_map_link', 'phone_number',
        'service_name', 'service_price', 'service_type', 'contract_start_date',
        'contract_end_date', 'status', 'comments'
    ];

    protected $casts = [
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'service_price' => 'decimal:2',
    ];

    /**
     * Relationship with MaintenanceHistory
     */
    public function maintenanceHistory()
    {
        return $this->hasMany(MaintenanceHistory::class, 'customer_id');
    }

    /**
     * Auto-generate customer ID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (empty($customer->customer_id)) {
                $customer->customer_id = 'GH' . date('Ymd') . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });

    }

    /**
     * Update contract status based on dates
     */
    public function updateContractStatus()
    {
        $today = Carbon::today();
        $endDate = Carbon::parse($this->contract_end_date);

        if ($today->gt($endDate)) {
            $this->status = 'expired';
        } elseif ($this->isContractExpiring()) {
            $this->status = 'active'; // Keep as active but show alert
        } else {
            $this->status = 'active';
        }
    }

    /**
     * Get all overdue maintenance dates - FIXED VERSION
     */
    public function getOverdueMaintenanceDates()
    {
        if ($this->hasContractExpired()) {
            return collect();
        }

        $overdueDates = collect();
        $lastMaintenance = $this->maintenanceHistory()->latest()->first();

        // Start from the appropriate date
        if ($lastMaintenance) {
            $startDate = Carbon::parse($lastMaintenance->maintenance_date)->startOfDay();
        } else {
            $startDate = Carbon::parse($this->contract_start_date)->startOfDay();
        }

        $interval = $this->service_type === 'host_system' ? 6 : 3;
        $today = Carbon::today()->startOfDay();

        // Calculate next expected maintenance date from last maintenance
        $nextExpectedDate = $startDate->copy()->addMonths($interval);

        // If next expected date is in the past, it's overdue
        while ($nextExpectedDate->lt($today)) {
            // Check if this overdue date was already completed
            if (!$this->isMaintenanceDateCompleted($nextExpectedDate)) {
                $overdueDates->push($nextExpectedDate->copy());
            }
            $nextExpectedDate = $nextExpectedDate->copy()->addMonths($interval);
        }

        return $overdueDates;
    }

    /**
     * Get next scheduled maintenance date (not overdue) - FIXED VERSION
     */
    public function getNextScheduledMaintenanceDate()
    {
        if ($this->hasContractExpired()) {
            return null;
        }

        $lastMaintenance = $this->maintenanceHistory()->latest()->first();

        if ($lastMaintenance) {
            $startDate = Carbon::parse($lastMaintenance->maintenance_date)->startOfDay();
        } else {
            $startDate = Carbon::parse($this->contract_start_date)->startOfDay();
        }

        $interval = $this->service_type === 'host_system' ? 6 : 3;
        $today = Carbon::today()->startOfDay();

        // Find the next maintenance date that is in the future
        $nextDate = $startDate->copy();
        while ($nextDate->lte($today)) {
            $nextDate = $nextDate->copy()->addMonths($interval);
        }

        return $nextDate;
    }

    /**
     * Get all maintenance alert dates for display in customer show page - FIXED VERSION
     */
    public function getAllMaintenanceAlertDates()
    {
        $alertDates = collect();

        // Add all overdue dates
        $overdueDates = $this->getOverdueMaintenanceDates()->sort();
        foreach ($overdueDates as $date) {
            // Check if this overdue date is not completed
            if (!$this->isMaintenanceDateCompleted($date)) {
                $daysOverdue = $this->getCalendarDaysDifference($date, Carbon::today());
                $alertDates->push([
                    'date' => $date,
                    'type' => 'overdue',
                    'days' => $daysOverdue,
                    'message' => 'Overdue by ' . abs($daysOverdue) . ' days'
                ]);
            }
        }

        // Add ALL upcoming scheduled dates within 7 days, not just the next one
        $allScheduledDates = $this->getAllScheduledMaintenanceDates();
        foreach ($allScheduledDates as $schedule) {
            if (!$schedule['completed'] && $schedule['type'] === 'upcoming') {
                $daysUntilNext = $schedule['days'];
                if ($daysUntilNext <= 7 && $daysUntilNext >= 0) {
                    $alertDates->push([
                        'date' => $schedule['date'],
                        'type' => 'upcoming',
                        'days' => $daysUntilNext,
                        'message' => 'Due in ' . $daysUntilNext . ' days'
                    ]);
                }
            }
        }

        return $alertDates;
    }

    /**
     * Calculate calendar days difference between two dates (pure day count) - FIXED VERSION
     */
    public function getCalendarDaysDifference($startDate, $endDate)
    {
        try {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->startOfDay();

            // Return negative if start is after end, positive if start is before end
            return $start->diffInDays($end, false);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get next maintenance date (for backward compatibility)
     */
    public function getNextMaintenanceDate()
    {
        $alert = $this->getMostUrgentMaintenanceAlert();
        return $alert ? $alert['date'] : $this->getNextScheduledMaintenanceDate();
    }

    /**
     * Get the most urgent maintenance alert (only one per customer) - FIXED VERSION
     */
    public function getMostUrgentMaintenanceAlert()
    {
        if ($this->hasContractExpired()) {
            return null;
        }

        // Get all overdue dates sorted by oldest first (most overdue)
        $overdueDates = $this->getOverdueMaintenanceDates()->sort();

        // If there are overdue dates, return the oldest one (most urgent)
        if ($overdueDates->count() > 0) {
            $oldestOverdue = $overdueDates->first();
            $daysOverdue = $this->getCalendarDaysDifference($oldestOverdue, Carbon::today());
            return [
                'date' => $oldestOverdue,
                'type' => 'overdue',
                'days' => $daysOverdue
            ];
        }

        // If no overdue, check for ALL upcoming maintenance within 7 days, not just the next one
        $allScheduledDates = $this->getAllScheduledMaintenanceDates();

        foreach ($allScheduledDates as $schedule) {
            if (!$schedule['completed'] && $schedule['type'] === 'upcoming') {
                $daysUntilNext = $schedule['days'];
                if ($daysUntilNext <= 7 && $daysUntilNext >= 0) {
                    return [
                        'date' => $schedule['date'],
                        'type' => 'upcoming',
                        'days' => $daysUntilNext
                    ];
                }
            }
        }

        // No maintenance alerts
        return null;
    }

    /**
     * Check if maintenance is due (has overdue or upcoming within 7 days)
     */
    public function isMaintenanceDue()
    {
        try {
            // If contract is expired, maintenance is not due
            if ($this->hasContractExpired()) {
                return false;
            }

            if ($this->status !== 'active') {
                return false;
            }

            return $this->getMostUrgentMaintenanceAlert() !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if contract is expiring (within 90 days)
     */
    public function isContractExpiring()
    {
        try {
            if ($this->status === 'expired') {
                return false;
            }

            $daysUntilEnd = $this->getDisplayDaysUntilExpiration();

            return $daysUntilEnd <= 90 && $daysUntilEnd > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if contract has expired
     */
    public function hasContractExpired()
    {
        try {
            $endDate = Carbon::parse($this->contract_end_date)->startOfDay();
            return Carbon::today()->startOfDay()->gt($endDate) || $this->status === 'expired';
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get display days until expiration - shows 0 if expired, positive number if active
     */
    public function getDisplayDaysUntilExpiration()
    {
        try {
            $today = Carbon::today()->startOfDay();
            $endDate = Carbon::parse($this->contract_end_date)->startOfDay();

            $days = $today->diffInDays($endDate, false);

            // If days is negative (expired), return 0
            return $days >= 0 ? $days : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get days since contract expired - returns positive number if expired
     */
    public function getDaysSinceExpiration()
    {
        try {
            if (!$this->hasContractExpired()) {
                return 0;
            }

            $today = Carbon::today()->startOfDay();
            $endDate = Carbon::parse($this->contract_end_date)->startOfDay();

            return $today->diffInDays($endDate);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Scope for active customers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for expiring contracts
     */
    public function scopeExpiringSoon($query)
    {
        return $query->where('contract_end_date', '<=', Carbon::today()->addDays(90))
                    ->where('contract_end_date', '>=', Carbon::today())
                    ->where('status', 'active');
    }

    /**
     * Scope for expired contracts
     */
    public function scopeExpired($query)
    {
        return $query->where('contract_end_date', '<', Carbon::today())
                    ->orWhere('status', 'expired');
    }

    /**
     * Get all scheduled maintenance dates (past and future) - FIXED VERSION
     */
    public function getAllScheduledMaintenanceDates()
    {
        if ($this->hasContractExpired()) {
            return collect();
        }

        $scheduledDates = collect();
        $lastMaintenance = $this->maintenanceHistory()->latest()->first();

        // Start from contract start date
        $startDate = Carbon::parse($this->contract_start_date)->startOfDay();
        $interval = $this->service_type === 'host_system' ? 6 : 3;
        $today = Carbon::today()->startOfDay();
        $contractEnd = Carbon::parse($this->contract_end_date)->startOfDay();

        // Generate all maintenance dates until contract end
        $nextDate = $startDate->copy();
        $maintenanceNumber = 1;

        while ($nextDate->lte($contractEnd)) {
            $isCompleted = $this->isMaintenanceDateCompleted($nextDate);

            // FIX: Calculate days difference correctly (today to maintenance date)
            $daysDiff = $today->diffInDays($nextDate, false); // false = don't return absolute value

            // Determine type based on actual date comparison
            if ($isCompleted) {
                $type = 'completed';
            } elseif ($nextDate->lt($today)) {
                $type = 'overdue';
            } elseif ($daysDiff <= 7) {
                $type = 'upcoming';
            } else {
                $type = 'scheduled';
            }

            // Only add if it's not completed OR if it's overdue
            if (!$isCompleted || $type === 'overdue') {
                $scheduledDates->push([
                    'date' => $nextDate->copy(),
                    'type' => $type,
                    'days' => $daysDiff, // This now shows negative for overdue, positive for future
                    'completed' => $isCompleted,
                    'maintenance_number' => $maintenanceNumber
                ]);
            }

            $nextDate = $nextDate->copy()->addMonths($interval);
            $maintenanceNumber++;

            // Limit to reasonable number to avoid infinite loop
            if ($maintenanceNumber > 50) break;
        }

        return $scheduledDates;
    }

    /**
     * Check if a specific maintenance date has been completed - FIXED VERSION
     */
    public function isMaintenanceDateCompleted($maintenanceDate)
    {
        if (!$maintenanceDate instanceof Carbon) {
            $maintenanceDate = Carbon::parse($maintenanceDate);
        }

        return $this->maintenanceHistory()
            ->whereDate('maintenance_date', $maintenanceDate->format('Y-m-d'))
            ->exists();
    }

    /**
     * Get the next maintenance date after a specific date
     */
    public function getNextMaintenanceDateAfter($date)
    {
        $interval = $this->service_type === 'host_system' ? 6 : 3;
        return Carbon::parse($date)->addMonths($interval)->startOfDay();
    }

    /**
     * RECALCULATE maintenance dates - NEW METHOD to force refresh
     */
    public function recalculateMaintenanceDates()
    {
        // Clear any cached relationships
        $this->unsetRelation('maintenanceHistory');

        // Force fresh calculation
        $this->getOverdueMaintenanceDates();
        $this->getNextScheduledMaintenanceDate();

        return $this;
    }
}
