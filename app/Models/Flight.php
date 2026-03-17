<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'flight_number',
        'origin_airport_id',
        'destination_airport_id',
        'departure_time',
        'arrival_time',
        'price',
        'airline',
        'capacity',
    ];

    public function originAirport()
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }
}
