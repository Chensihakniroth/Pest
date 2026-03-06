<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Airport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FlightController extends Controller
{
    public function searchForm()
    {
        $airports = Airport::all();
        return view('flights.search', compact('airports'));
    }

    public function index(Request $request)
    {
        $request->validate([
            'origin' => 'nullable|exists:airports,id',
            'destination' => 'nullable|exists:airports,id',
            'departure_date' => 'nullable|date|after_or_equal:today',
        ]);

        $query = Flight::query();

        if ($request->filled('origin')) {
            $query->where('origin_airport_id', $request->origin);
        }

        if ($request->filled('destination')) {
            $query->where('destination_airport_id', $request->destination);
        }

        if ($request->filled('departure_date')) {
            $date = Carbon::parse($request->departure_date)->startOfDay();
            $query->whereDate('departure_time', $date);
        }

        $flights = $query->with(['originAirport', 'destinationAirport'])->get();

        return view('flights.index', compact('flights'));
    }

    public function show(Flight $flight)
    {
        return view('flights.show', compact('flight'));
    }
}
