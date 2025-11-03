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
     * Get next maintenance date
     */
    public function getNextMaintenanceDate()
    {
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
     * Check if maintenance is due (within 3 days)
     */
    public function isMaintenanceDue()
    {
        try {
            $nextMaintenance = $this->getNextMaintenanceDate();
            return now()->diffInDays($nextMaintenance, false) <= 3;
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
            $endDate = Carbon::parse($this->contract_end_date);
            return now()->diffInDays($endDate, false) <= 90 && now()->diffInDays($endDate, false) >= 0;
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
            return now()->gt(Carbon::parse($this->contract_end_date));
        } catch (\Exception $e) {
            return false;
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
        return $query->where('contract_end_date', '<=', now()->addDays(90))
                    ->where('contract_end_date', '>=', now());
    }
}