<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'fare_class' => 'required|in:economy,business,first',
            'seat_number' => 'required|string|max:10',
        ]);

        $flight = Flight::find($request->flight_id);

        if (!$flight) {
            return back()->with('error', 'Flight not found.');
        }

        if ($flight->capacity <= 0) {
            return back()->with('error', 'Sorry, this flight is fully booked.');
        }

        // Calculate total price based on fare class
        $multipliers = [
            'economy' => 1,
            'business' => 2,
            'first' => 3,
        ];
        $totalPrice = $flight->price * $multipliers[$request->fare_class];

        // Use a database transaction for atomicity
        return DB::transaction(function () use ($request, $flight, $totalPrice) {
            // Create booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'flight_id' => $flight->id,
                'fare_class' => $request->fare_class,
                'seat_number' => $request->seat_number,
                'booking_reference' => 'BK-' . Str::upper(Str::random(8)),
                'status' => 'confirmed', // Assuming instant confirmation for now
                'total_price' => $totalPrice,
            ]);

            // Reduce flight capacity
            $flight->decrement('capacity');

            return redirect()->route('bookings.show', $booking->id)
                             ->with('success', 'Flight booked successfully!');
        });
    }

    public function show(Booking $booking)
    {
        // Ensure the authenticated user owns the booking or is an admin
        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('bookings.show', compact('booking'));
    }

    public function index()
    {
        $bookings = Auth::user()->bookings()->with('flight.originAirport', 'flight.destinationAirport')->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function boardingPass(Booking $booking)
    {
        // Ensure the authenticated user owns the booking
        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['flight.originAirport', 'flight.destinationAirport']);
        
        return view('bookings.boarding-pass', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        // Ensure user can only cancel their own or if admin
        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled.');
        }

        return DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);
            
            // Restore capacity
            $booking->flight->increment('capacity');

            return back()->with('success', 'Booking cancelled successfully.');
        });
    }
}
