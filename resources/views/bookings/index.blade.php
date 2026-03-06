@extends('layouts.app')

@section('title', 'My Trips - SkyConnect')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-5 reveal">
        <div>
            <h6 class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: 2px;">Travel Identity</h6>
            <h1 class="display-5 fw-800 text-dark mb-0">My Journeys</h1>
        </div>
        <div class="text-end">
            <a href="{{ route('flights.searchForm') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-800">
                <i class="fas fa-plus me-2"></i> New Reservation
            </a>
        </div>
    </div>

    @if ($bookings->isEmpty())
        <div class="card p-5 text-center border-0 shadow-sm reveal" style="border-radius: 30px;">
            <div class="mb-4">
                <i class="fas fa-passport fa-4x text-light"></i>
            </div>
            <h3 class="fw-800 text-dark">No Active Trips</h3>
            <p class="text-secondary lead mb-4">Your passport is waiting for its first SkyConnect stamp.</p>
            <div class="d-flex justify-content-center">
                <a href="{{ route('flights.searchForm') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-800">Explore Destinations</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($bookings as $booking)
                <div class="col-lg-6 reveal">
                    <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 25px;">
                        <!-- Trip Header -->
                        <div class="p-4 d-flex justify-content-between align-items-center" style="background: rgba(0, 122, 255, 0.05);">
                            <div>
                                <span class="badge bg-white text-primary border rounded-pill px-3 py-2 mb-2 small fw-bold">
                                    {{ strtoupper($booking->fare_class) }}
                                </span>
                                <div class="small text-secondary fw-bold">REF: {{ $booking->booking_reference }}</div>
                            </div>
                            <div class="text-end">
                                @if($booking->status === 'confirmed')
                                    <span class="badge bg-success rounded-pill px-3 py-2 fw-bold">CONFIRMED</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-2 fw-bold">{{ strtoupper($booking->status) }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Trip Body -->
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center text-center mb-4">
                                <div style="flex: 1;">
                                    <h2 class="fw-800 text-dark mb-0">{{ $booking->flight->originAirport->code }}</h2>
                                    <p class="small text-secondary mb-0">{{ $booking->flight->originAirport->city }}</p>
                                </div>
                                <div class="px-3" style="flex: 0.5;">
                                    <i class="fas fa-plane text-primary opacity-25"></i>
                                </div>
                                <div style="flex: 1;">
                                    <h2 class="fw-800 text-dark mb-0">{{ $booking->flight->destinationAirport->code }}</h2>
                                    <p class="small text-secondary mb-0">{{ $booking->flight->destinationAirport->city }}</p>
                                </div>
                            </div>

                            <div class="row g-3 py-3 border-top border-bottom mb-4">
                                <div class="col-6">
                                    <p class="x-small text-muted text-uppercase mb-1 fw-bold">Departure</p>
                                    <p class="small fw-bold text-dark mb-0">{{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="x-small text-muted text-uppercase mb-1 fw-bold">Seat</p>
                                    <p class="small fw-bold text-dark mb-0">{{ $booking->seat_number ?? 'Not Assigned' }}</p>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-light flex-grow-1 rounded-pill fw-bold border">
                                    <i class="fas fa-info-circle me-2"></i> Details
                                </a>
                                @if($booking->status === 'confirmed')
                                    <a href="{{ route('bookings.boardingPass', $booking->id) }}" class="btn btn-primary flex-grow-1 rounded-pill fw-bold shadow-sm">
                                        <i class="fas fa-ticket-alt me-2"></i> Boarding Pass
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection