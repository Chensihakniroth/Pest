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

    // Relationship with MaintenanceHistory
    public function maintenanceHistory()
    {
        return $this->hasMany(MaintenanceHistory::class);
    }

    // Auto-generate customer ID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (empty($customer->customer_id)) {
                $customer->customer_id = 'GH' . date('Ymd') . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Get next maintenance date (instance method)
    public function getNextMaintenanceDate()
    {
        $lastMaintenance = $this->maintenanceHistory()->latest()->first();
        $startDate = $lastMaintenance ? 
            Carbon::parse($lastMaintenance->maintenance_date) : 
            Carbon::parse($this->contract_start_date);
        
        $interval = $this->service_type === 'host_system' ? 6 : 3;
        
        return $startDate->copy()->addMonths($interval);
    }

    // Check if maintenance is due (instance method)
    public function isMaintenanceDue()
    {
        $nextMaintenance = $this->getNextMaintenanceDate();
        return now()->diffInDays($nextMaintenance, false) <= 3;
    }

    // Check if contract is expiring (instance method)
    public function isContractExpiring()
    {
        $endDate = Carbon::parse($this->contract_end_date);
        return now()->diffInDays($endDate, false) <= 90 && now()->diffInDays($endDate, false) >= 0;
    }

    // Check if contract has expired (instance method)
    public function hasContractExpired()
    {
        return now()->gt(Carbon::parse($this->contract_end_date));
    }
}