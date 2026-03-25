<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user',
        'flight',
        'booking_reference',
        'status',
        'total_price',
        'fare_class',
        'seat_number',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function flightDetails()
    {
        return $this->belongsTo(Flight::class, 'flight');
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
