@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center text-dark">Booking Details - {{ $booking->booking_reference }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title text-dark">Booking Information</h5>
            <p class="card-text text-secondary"><strong>Booking Reference:</strong> <span class="text-dark">{{ $booking->booking_reference }}</span></p>
            <p class="card-text text-secondary"><strong>Status:</strong> <span class="text-dark">{{ ucfirst($booking->status) }}</span></p>
            <p class="card-text text-secondary"><strong>Total Price:</strong> <span class="text-primary fw-bold">${{ number_format($booking->total_price, 2) }}</span></p>
            <p class="card-text text-secondary"><strong>Booked On:</strong> <span class="text-dark">{{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y H:i A') }}</span></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title text-dark">Flight Information</h5>
            <p class="card-text text-secondary"><strong>Flight Number:</strong> <span class="text-dark">{{ $booking->flight->flight_number }}</span></p>
            <p class="card-text text-secondary"><strong>Airline:</strong> <span class="text-dark">{{ $booking->flight->airline }}</span></p>
            <p class="card-text text-secondary"><strong>Route:</strong> <span class="text-dark">{{ $booking->flight->originAirport->code }} to {{ $booking->flight->destinationAirport->code }}</span></p>
            <p class="card-text text-secondary"><strong>Departure:</strong> <span class="text-dark">{{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('M d, Y H:i A') }}</span></p>
            <p class="card-text text-secondary"><strong>Arrival:</strong> <span class="text-dark">{{ \Carbon\Carbon::parse($booking->flight->arrival_time)->format('M d, Y H:i A') }}</span></p>
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('my-bookings.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left me-2"></i>Back to My Bookings
        </a>
    </div>
</div>
@endsection