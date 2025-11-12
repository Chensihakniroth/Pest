<?php
// app/Models/MaintenanceHistory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'maintenance_date',
        'service_type',
        'notes',
        'performed_by'
    ];

    protected $casts = [
        'maintenance_date' => 'date',
    ];

    /**
     * Relationship with Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get service type display name
     */
    public function getServiceTypeDisplayAttribute()
    {
        return \App\Models\Customer::SERVICE_TYPES[$this->service_type] ?? $this->service_type;
    }
}
