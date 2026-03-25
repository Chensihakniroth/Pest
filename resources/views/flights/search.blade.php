@extends('layouts.app')

@section('title', 'Explore Destinations - SkyConnect')

@section('content')
<div class="container-fluid py-5 px-lg-5">
    <div class="row mb-5 reveal">
        <div class="col-lg-8">
            <h6 class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: 3px;">Your Journey Begins</h6>
            <h1 class="display-3 fw-800 text-dark mb-0" style="letter-spacing: -2px;">Explore the World.</h1>
            <p class="lead text-secondary mt-3">Select your departure point to view available boutique routes.</p>
        </div>
    </div>

    <!-- Search Interface -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="mirror-card p-4 p-lg-5 rounded-5 shadow-lg border-0 bg-white bg-opacity-50" style="backdrop-filter: blur(20px);">
                <div class="row g-4 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-secondary text-uppercase ms-2">Departure City</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 rounded-start-pill ps-4"><i class="fas fa-plane-departure text-primary"></i></span>
                            <select id="origin-select" class="form-select border-0 rounded-end-pill py-3 shadow-none fw-bold" onchange="handleOriginChange()">
                                <option value="" selected disabled>Select origin...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 text-center d-none d-md-block">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-exchange-alt text-primary"></i></div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-secondary text-uppercase ms-2">Destination</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 rounded-start-pill ps-4"><i class="fas fa-map-marker-alt text-primary"></i></span>
                            <select id="destination-select" class="form-select border-0 rounded-end-pill py-3 shadow-none fw-bold" disabled onchange="loadFlights()">
                                <option value="" selected disabled>Awaiting selection...</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="row">
        <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-800 text-dark mb-0">Available Routes</h4>
            <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 border-0 fw-bold"><i class="fas fa-wifi me-1"></i> NODE.JS BRAIN ACTIVE</div>
        </div>
        <div id="flight-results" class="row g-4"><div class="col-12 text-center py-5"><p class="text-secondary">Please select your route to view flights.</p></div></div>
    </div>
</div>

<style>
    .shimmer { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: loading 1.5s infinite; height: 300px; }
    @keyframes loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
</style>

@push('scripts')
<script>
const NODE_API = 'http://localhost:3000';
let allFlightsCache = [];

document.addEventListener('DOMContentLoaded', () => {
    console.clear();
    console.log('%c ☁️ SKYCONNECT SEARCH ENGINE ONLINE ', 'color: #5856d6; font-weight: bold; font-size: 14px;');
    initSearch();
});

async function apiCall(endpoint, method = 'GET') {
    const url = NODE_API + endpoint;
    const colors = { 'GET': '#34c759', 'POST': '#ff9500' };
    
    const options = { method, headers: { 'Accept': 'application/json' } };
    if (window.API_TOKEN) options.headers['Authorization'] = 'Bearer ' + window.API_TOKEN;

    try {
        const response = await fetch(url, options);
        const data = await response.json();
        console.log(`%c ${response.status} %c ${method} %c → %c ${url}`, `background: #1c1c1e; color: #34c759; padding: 2px 6px; border-radius: 3px; font-weight: bold;`, `background: #34c759; color: white; padding: 2px 6px; border-radius: 3px; font-weight: bold;`, '', 'color: #5856d6;');
        return data;
    } catch (err) { console.error(err); throw err; }
}

async function initSearch() {
    allFlightsCache = await apiCall('/api/flights');
    const origins = {};
    allFlightsCache.forEach(f => { if (f.origin_airport_id) origins[f.origin_airport_id._id] = f.origin_airport_id; });
    const select = document.getElementById('origin-select');
    select.innerHTML = '<option value="" selected disabled>Select origin...</option>' + 
        Object.values(origins).map(a => `<option value="${a._id}">${a.city} (${a.code})</option>`).join('');
}

function handleOriginChange() {
    const originId = document.getElementById('origin-select').value;
    const destSelect = document.getElementById('destination-select');
    
    // Filter flights from this origin to find destinations
    const availableDests = {};
    allFlightsCache.filter(f => f.origin_airport_id?._id === originId).forEach(f => {
        if (f.destination_airport_id) availableDests[f.destination_airport_id._id] = f.destination_airport_id;
    });

    destSelect.disabled = false;
    destSelect.innerHTML = '<option value="" selected disabled>Choose destination...</option>' +
        Object.values(availableDests).map(a => `<option value="${a._id}">${a.city} (${a.code})</option>`).join('');
    
    document.getElementById('flight-results').innerHTML = '<div class="col-12 text-center py-5"><p class="text-secondary">Now select your destination.</p></div>';
}

async function loadFlights() {
    const originId = document.getElementById('origin-select').value;
    const destId = document.getElementById('destination-select').value;
    const container = document.getElementById('flight-results');
    container.innerHTML = '<div class="col-md-4"><div class="shimmer rounded-5"></div></div>'.repeat(3);

    const filtered = allFlightsCache.filter(f => 
        f.origin_airport_id?._id === originId && f.destination_airport_id?._id === destId
    );
    
    if (filtered.length === 0) {
        container.innerHTML = '<div class="col-12 text-center py-5"><h5>No flights found for this specific route.</h5></div>';
        return;
    }

    container.innerHTML = filtered.map(f => `
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 rounded-5 shadow-sm overflow-hidden h-100 bg-white trip-card">
                <div class="bg-primary p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold opacity-75">${f.airline}</span>
                        <span class="badge bg-white text-primary rounded-pill px-3">${f.flight_number}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="fw-800 mb-0">${f.origin_airport_id.code}</h2>
                        <i class="fas fa-plane fa-lg opacity-50"></i>
                        <h2 class="fw-800 mb-0">${f.destination_airport_id.code}</h2>
                    </div>
                </div>
                <div class="p-4 mt-auto">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="fw-800 text-primary mb-0">$${f.price.toLocaleString()}</h3>
                        <a href="/bookings/create?flight_id=${f._id}" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">Select Flight</a>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}
</script>
@endpush
@endsection
