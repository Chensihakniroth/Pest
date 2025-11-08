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

        // Auto-update status based on contract dates
        static::saving(function ($customer) {
            $customer->updateContractStatus();
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
     * Get next maintenance date - returns null if contract expired
     */
    public function getNextMaintenanceDate()
    {
        // If contract is expired, no more maintenance
        if ($this->hasContractExpired()) {
            return null;
        }

        $lastMaintenance = $this->maintenanceHistory()->latest()->first();

        if ($lastMaintenance) {
            $startDate = Carbon::parse($lastMaintenance->maintenance_date);
        } else {
            $startDate = Carbon::parse($this->contract_start_date);
        }

        $interval = $this->service_type === 'host_system' ? 6 : 3;

        return $startDate->copy()->addMonths($interval);
    }

    /**
     * Check if maintenance is due (within 7 days) - returns false if contract expired
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

            $nextMaintenance = $this->getNextMaintenanceDate();

            // If no next maintenance date (expired contract), return false
            if (!$nextMaintenance) {
                return false;
            }

            return $this->getCalendarDaysUntil($nextMaintenance) <= 7;
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
            $endDate = Carbon::parse($this->contract_end_date);
            return Carbon::today()->gt($endDate) || $this->status === 'expired';
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
            $today = Carbon::today();
            $endDate = Carbon::parse($this->contract_end_date)->startOfDay();

            $days = $today->diffInDays($endDate, false);

            // If days is negative (expired), return 0
            return $days >= 0 ? $days : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get calendar days until a specific date (date-only comparison)
     */
    public function getCalendarDaysUntil($targetDate)
    {
        try {
            $today = Carbon::today();
            $target = Carbon::parse($targetDate)->startOfDay();

            return $today->diffInDays($target, false);
        } catch (\Exception $e) {
            return null;
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

            $today = Carbon::today();
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
}
