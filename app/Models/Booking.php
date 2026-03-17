<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'flight_id',
        'booking_reference',
        'status',
        'total_price',
        'fare_class',
        'seat_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
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
