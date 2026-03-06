<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function show(Booking $booking)
    {
        // Ensure the authenticated user owns the booking
        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if booking already has a payment
        if ($booking->payment) {
            return redirect()->route('bookings.show', $booking->id)
                             ->with('info', 'This booking has already been paid for.');
        }

        return view('payments.process', compact('booking'));
    }

    public function process(Request $request, Booking $booking)
    {
        // Ensure the authenticated user owns the booking
        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if booking already has a payment
        if ($booking->payment) {
            return redirect()->route('bookings.show', $booking->id)
                             ->with('error', 'This booking has already been paid for.');
        }

        $request->validate([
            'card_number' => 'required|string|min:16|max:16',
            'card_holder_name' => 'required|string|max:100',
            'card_expiry_month' => 'required|string|size:2',
            'card_expiry_year' => 'required|string|size:4',
            'card_cvv' => 'required|string|size:3',
        ]);

        return DB::transaction(function () use ($request, $booking) {
            // Create payment record (mocking the payment processing)
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'booking_id' => $booking->id,
                'payment_reference' => 'PAY-' . Str::upper(Str::random(10)),
                'card_number' => $request->card_number,
                'card_holder_name' => $request->card_holder_name,
                'card_expiry_month' => $request->card_expiry_month,
                'card_expiry_year' => $request->card_expiry_year,
                'card_cvv' => $request->card_cvv, // In real app, this should be encrypted
                'amount' => $booking->total_price,
                'status' => 'completed', // Mocking successful payment
                'payment_method' => 'credit_card',
                'paid_at' => now(),
            ]);

            // Update booking status to paid
            $booking->update(['status' => 'confirmed']);

            return redirect()->route('bookings.show', $booking->id)
                             ->with('success', 'Payment processed successfully! Your booking is now confirmed.');
        });
    }

    public function index()
    {
        $payments = Auth::user()->payments()->with('booking.flight.originAirport', 'booking.flight.destinationAirport')->latest()->get();
        return view('payments.index', compact('payments'));
    }
}
