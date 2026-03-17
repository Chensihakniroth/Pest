<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Passenger extends Model
{
    protected $fillable = [
        'booking_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'passport_number',
        'seat_number',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
