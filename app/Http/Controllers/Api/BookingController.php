<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return response()->json(Booking::with(['user', 'flight.originAirport', 'flight.destinationAirport'])->latest()->get());
    }

    public function show($id)
    {
        return response()->json(Booking::with(['user', 'flight.originAirport', 'flight.destinationAirport', 'passengers'])->findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'flight_id' => 'required',
            'booking_reference' => 'required|unique:bookings',
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'required|numeric',
        ]);

        $booking = Booking::create($validated);
        return response()->json($booking, 201);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return response()->json($booking);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
