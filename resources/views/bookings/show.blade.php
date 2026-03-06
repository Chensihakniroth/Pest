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

    <!-- Payment Section -->
    @if(!$booking->payment && $booking->status !== 'cancelled')
        <div class="card mb-4 border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-warning mb-2">Payment Required</h5>
                        <p class="card-text text-muted mb-0">Complete your payment to confirm this booking.</p>
                    </div>
                    <div>
                        <a href="{{ route('payments.show', $booking) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-credit-card me-2"></i>Process Payment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @elseif($booking->payment)
        <div class="card mb-4 border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-success mb-2">Payment Completed</h5>
                        <p class="card-text text-muted mb-0">Payment Reference: {{ $booking->payment->payment_reference }}</p>
                        <p class="card-text text-muted mb-0">Paid: {{ $booking->payment->paid_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle me-2"></i> Paid
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="text-center mt-3">
        <a href="{{ route('my-bookings.index') }}" class="btn btn-secondary btn-lg me-2">
            <i class="fas fa-arrow-left me-2"></i>Back to My Bookings
        </a>
        @if($booking->payment)
            <a href="{{ route('payments.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-history me-2"></i>Payment History
            </a>
        @endif
    </div>
</div>
@endsection
