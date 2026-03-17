<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        return response()->json(Flight::with(['originAirport', 'destinationAirport'])->latest()->get());
    }

    public function show($id)
    {
        return response()->json(Flight::with(['originAirport', 'destinationAirport'])->findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required|unique:flights',
            'origin_airport_id' => 'required',
            'destination_airport_id' => 'required',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'price' => 'required|numeric',
            'airline' => 'required|string',
            'capacity' => 'required|integer',
        ]);

        $flight = Flight::create($validated);
        return response()->json($flight, 201);
    }

    public function update(Request $request, $id)
    {
        $flight = Flight::findOrFail($id);
        $flight->update($request->all());
        return response()->json($flight);
    }

    public function destroy($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();
        return response()->json(['message' => 'Flight deleted successfully']);
    }
}
