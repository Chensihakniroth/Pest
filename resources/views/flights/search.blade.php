@extends('layouts.app')

@section('title', 'Find Your Journey - SkyConnect')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5 reveal">
        <h6 class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: 3px;">Ready for takeoff?</h6>
        <h1 class="display-5 fw-800 text-dark">Find Your Flight</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card p-5 border-0 shadow-lg" style="border-radius: 35px !important; background: rgba(255,255,255,0.8); backdrop-filter: blur(20px);">
                <form action="{{ route('flights.index') }}" method="GET">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="origin" class="form-label text-secondary small fw-bold text-uppercase ms-2">From</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill ps-4 text-primary"><i class="fas fa-plane-departure"></i></span>
                                <select class="form-select border-0 bg-light rounded-end-pill py-3 px-3" id="origin" name="origin">
                                    <option value="">Any Origin</option>
                                    @foreach ($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ request('origin') == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->city }} ({{ $airport->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="destination" class="form-label text-secondary small fw-bold text-uppercase ms-2">To</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill ps-4 text-primary"><i class="fas fa-plane-arrival"></i></span>
                                <select class="form-select border-0 bg-light rounded-end-pill py-3 px-3" id="destination" name="destination">
                                    <option value="">Any Destination</option>
                                    @foreach ($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ request('destination') == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->city }} ({{ $airport->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="departure_date" class="form-label text-secondary small fw-bold text-uppercase ms-2">Departure Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill ps-4 text-primary"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" class="form-control border-0 bg-light rounded-end-pill py-3 px-3" id="departure_date" name="departure_date" value="{{ request('departure_date') }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg shadow-lg py-3 rounded-pill fw-800" style="font-size: 1.2rem;">
                            <i class="fas fa-search me-2"></i> Search Elite Routes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Links for popular searches -->
    <div class="mt-5 text-center reveal">
        <p class="text-secondary small fw-bold mb-4">POPULAR DESTINATIONS</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('flights.index', ['destination' => 1]) }}" class="badge bg-white text-dark p-3 px-4 text-decoration-none shadow-sm rounded-pill hover-primary">
                New York (JFK)
            </a>
            <a href="{{ route('flights.index', ['destination' => 4]) }}" class="badge bg-white text-dark p-3 px-4 text-decoration-none shadow-sm rounded-pill hover-primary">
                London (LHR)
            </a>
            <a href="{{ route('flights.index', ['destination' => 7]) }}" class="badge bg-white text-dark p-3 px-4 text-decoration-none shadow-sm rounded-pill hover-primary">
                Tokyo (HND)
            </a>
            <a href="{{ route('flights.index', ['destination' => 6]) }}" class="badge bg-white text-dark p-3 px-4 text-decoration-none shadow-sm rounded-pill hover-primary">
                Dubai (DXB)
            </a>
        </div>
    </div>
</div>

<style>
.hover-primary:hover {
    background: var(--sc-primary) !important;
    color: white !important;
    transform: translateY(-2px);
}
</style>
@endsection