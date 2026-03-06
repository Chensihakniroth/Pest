@extends('layouts.app')

@section('title', 'Boarding Pass - ' . $booking->booking_reference)

@section('content')
<div class="container py-4 d-flex justify-content-center">
    <div class="boarding-pass-container" style="max-width: 400px; width: 100%;">
        <div class="card boarding-pass-card shadow-lg" style="border-radius: 24px; overflow: hidden; background: linear-gradient(135deg, var(--sc-primary), var(--sc-primary-dark)); border: none;">
            <!-- Header -->
            <div class="card-header border-0 text-white d-flex justify-content-between align-items-center p-4" style="background: transparent;">
                <div class="airline-info">
                    <i class="fas fa-plane me-2"></i>
                    <span class="fw-bold" style="letter-spacing: 1px;">SKYCONNECT</span>
                </div>
                <div class="class-info">
                    <span class="badge bg-white text-primary rounded-pill px-3">{{ strtoupper($booking->fare_class) }}</span>
                </div>
            </div>

            <!-- Route Info -->
            <div class="card-body text-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="origin text-center">
                        <h1 class="display-4 fw-bold mb-0">{{ $booking->flight->originAirport->code }}</h1>
                        <p class="small opacity-75 mb-0">{{ $booking->flight->originAirport->city }}</p>
                    </div>
                    <div class="plane-icon text-center mx-3">
                        <i class="fas fa-plane fa-2x opacity-50"></i>
                    </div>
                    <div class="destination text-center">
                        <h1 class="display-4 fw-bold mb-0">{{ $booking->flight->destinationAirport->code }}</h1>
                        <p class="small opacity-75 mb-0">{{ $booking->flight->destinationAirport->city }}</p>
                    </div>
                </div>

                <hr style="border-top: 1px dashed rgba(255,255,255,0.3);">

                <!-- Flight Details -->
                <div class="row g-3 py-3">
                    <div class="col-6">
                        <p class="small opacity-75 mb-1">PASSENGER</p>
                        <p class="fw-bold mb-0 text-uppercase">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="small opacity-75 mb-1">FLIGHT</p>
                        <p class="fw-bold mb-0 text-uppercase">{{ $booking->flight->flight_number }}</p>
                    </div>
                    <div class="col-6">
                        <p class="small opacity-75 mb-1">DATE</p>
                        <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('d M Y') }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="small opacity-75 mb-1">DEPARTURE</p>
                        <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('H:i') }}</p>
                    </div>
                    <div class="col-6">
                        <p class="small opacity-75 mb-1">GATE</p>
                        <p class="fw-bold mb-0">B12</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="small opacity-75 mb-1">SEAT</p>
                        <p class="fw-bold mb-0">{{ $booking->seat_number ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer / QR Section -->
            <div class="card-footer bg-white p-4 text-center" style="border-top: 1px dashed #dee2e6; border-bottom-left-radius: 24px; border-bottom-right-radius: 24px;">
                <div class="qr-placeholder mx-auto mb-3" style="width: 150px; height: 150px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 12px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                    <!-- Simple Mock QR Design -->
                    <div style="width: 80%; height: 80%; display: grid; grid-template-columns: repeat(10, 1fr); grid-template-rows: repeat(10, 1fr); gap: 2px;">
                        @for($i = 0; $i < 100; $i++)
                            <div style="background: {{ rand(0, 1) ? '#000' : 'transparent' }};"></div>
                        @endfor
                    </div>
                </div>
                <p class="small text-muted mb-0">BOOKING REF: <span class="fw-bold text-dark">{{ $booking->booking_reference }}</span></p>
            </div>
        </div>

        <div class="text-center mt-4">
            <button onclick="window.print()" class="btn btn-primary me-2">
                <i class="fas fa-print me-2"></i>Print Pass
            </button>
            <a href="{{ route('my-bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>My Bookings
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    .navbar, .footer, button, .btn {
        display: none !important;
    }
    body {
        background: white !important;
        padding-top: 0 !important;
    }
    .container {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
}
</style>
@endsection