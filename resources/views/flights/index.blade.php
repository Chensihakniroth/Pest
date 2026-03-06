@extends('layouts.app')

@section('title', 'Available Flights - SkyConnect')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-5 reveal">
        <div>
            <h6 class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: 2px;">Search Results</h6>
            <h1 class="display-5 fw-800 text-dark mb-0">Select Your Flight</h1>
        </div>
        <div class="text-end">
            <a href="{{ route('flights.searchForm') }}" class="btn btn-light rounded-pill px-4 shadow-sm border small fw-bold">
                <i class="fas fa-sliders me-2"></i> Modify Search
            </a>
        </div>
    </div>

    @if ($flights->isEmpty())
        <div class="card p-5 text-center border-0 shadow-sm reveal" style="border-radius: 30px;">
            <div class="mb-4">
                <i class="fas fa-plane-slash fa-4x text-light"></i>
            </div>
            <h3 class="fw-800 text-dark">No Flights Found</h3>
            <p class="text-secondary lead mb-4">We couldn't find any elite routes matching your criteria today.</p>
            <div class="d-flex justify-content-center">
                <a href="{{ route('flights.searchForm') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-800">Try Another Date</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($flights as $flight)
                <div class="col-12 reveal">
                    <div class="card border-0 shadow-sm hover-mirror p-4" style="border-radius: 25px; transition: all 0.4s ease;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Airline Info -->
                                <div class="col-lg-3 mb-4 mb-lg-0">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3 text-primary">
                                            <i class="fas fa-plane fa-lg"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-800 mb-0 text-dark">{{ $flight->airline }}</h5>
                                            <p class="small text-secondary mb-0">Flight {{ $flight->flight_number }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Route & Times -->
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <div class="d-flex justify-content-between align-items-center text-center px-lg-4">
                                        <div style="flex: 1;">
                                            <h3 class="fw-800 mb-0 text-dark">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</h3>
                                            <p class="small fw-bold text-primary mb-0">{{ $flight->originAirport->code }}</p>
                                            <p class="text-secondary x-small" style="font-size: 0.7rem;">{{ $flight->originAirport->city }}</p>
                                        </div>
                                        
                                        <div class="px-4 text-center position-relative" style="flex: 1.5;">
                                            <p class="small text-secondary mb-1">Non-stop</p>
                                            <div class="position-relative">
                                                <hr class="m-0 border-primary opacity-25">
                                                <i class="fas fa-plane text-primary position-absolute start-50 translate-middle bg-white px-2" style="top: 0;"></i>
                                            </div>
                                            <p class="text-secondary x-small mt-1" style="font-size: 0.7rem;">
                                                {{ \Carbon\Carbon::parse($flight->departure_time)->diffForHumans(\Carbon\Carbon::parse($flight->arrival_time), true) }}
                                            </p>
                                        </div>

                                        <div style="flex: 1;">
                                            <h3 class="fw-800 mb-0 text-dark">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</h3>
                                            <p class="small fw-bold text-primary mb-0">{{ $flight->destinationAirport->code }}</p>
                                            <p class="text-secondary x-small" style="font-size: 0.7rem;">{{ $flight->destinationAirport->city }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing & Action -->
                                <div class="col-lg-3 text-lg-end border-start-lg">
                                    <div class="ps-lg-4">
                                        <p class="small text-secondary mb-1">Starting from</p>
                                        <h2 class="fw-800 text-dark mb-3">${{ number_format($flight->price, 2) }}</h2>
                                        <a href="{{ route('flights.show', $flight->id) }}" class="btn btn-primary w-100 rounded-pill py-3 fw-800 shadow-sm">
                                            Select Flight <i class="fas fa-chevron-right ms-2 small"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.hover-mirror:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 122, 255, 0.1) !important;
    background: rgba(255, 255, 255, 0.9) !important;
}
@media (min-width: 992px) {
    .border-start-lg { border-left: 1px solid rgba(0,0,0,0.05) !important; }
}
</style>
@endsection