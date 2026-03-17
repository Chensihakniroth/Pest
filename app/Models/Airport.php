<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'code',
        'name',
        'city',
        'country',
    ];

    public function flightsAsOrigin()
    {
        return $this->hasMany(Flight::class, 'origin_airport_id');
    }

    public function flightsAsDestination()
    {
        return $this->hasMany(Flight::class, 'destination_airport_id');
    }
}
