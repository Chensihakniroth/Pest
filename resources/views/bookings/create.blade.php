@extends('layouts.app')

@section('title', 'Finalize Booking - SkyConnect')

@section('content')
<div class="container-fluid py-5 px-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h6 class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: 3px;">Final Step</h6>
            <h1 class="display-4 fw-800 text-dark mb-5" style="letter-spacing: -1.5px;">Complete Reservation</h1>

            <!-- Flight Summary Card (Skeleton state initially) -->
            <div id="flight-summary" class="mb-5">
                <div class="shimmer rounded-5" style="height: 200px;"></div>
            </div>

            <!-- Passenger Form -->
            <div class="mirror-card p-4 p-lg-5 rounded-5 shadow-lg border-0 bg-white bg-opacity-50 mb-5" style="backdrop-filter: blur(20px);">
                <h4 class="fw-800 text-dark mb-4">Passenger Details</h4>
                <form id="booking-form">
                    @php
                        $nameParts = explode(' ', auth()->user()->name, 2);
                        $firstName = $nameParts[0] ?? '';
                        $lastName = $nameParts[1] ?? '';
                    @endphp
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase ms-2">First Name</label>
                            <input type="text" id="p-first-name" class="form-control border-0 bg-light rounded-pill py-3 px-4 shadow-none fw-bold" value="{{ $firstName }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase ms-2">Last Name</label>
                            <input type="text" id="p-last-name" class="form-control border-0 bg-light rounded-pill py-3 px-4 shadow-none fw-bold" value="{{ $lastName }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary text-uppercase ms-2">Passport Number</label>
                            <input type="text" id="p-passport" class="form-control border-0 bg-light rounded-pill py-3 px-4 shadow-none fw-bold" placeholder="A1234567" required>
                        </div>
                        
                        <!-- Seat Selection -->
                        <div class="col-12 mt-4">
                            <h5 class="fw-bold mb-3"><i class="fas fa-chair me-2 text-primary"></i>Seat Selection</h5>
                            <div class="seat-map p-4 rounded-5 border bg-white text-center overflow-auto" style="min-height: 200px;">
                                <div id="seat-grid" class="d-inline-block">
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>
                            </div>
                            <input type="hidden" id="p-seat" required>
                            <div class="text-center mt-3">
                                <span class="badge bg-primary px-4 py-2 fs-6 rounded-pill shadow-sm" id="selected-seat-display">Select a seat</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 border-top pt-4 text-end">
                        <div class="mb-4">
                            <span class="text-secondary small fw-bold text-uppercase d-block mb-1">Total Amount</span>
                            <h2 id="display-total" class="fw-800 text-primary mb-0">$0.00</h2>
                        </div>
                        <button type="submit" id="confirm-btn" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold shadow-lg" disabled>
                            CONFIRM RESERVATION
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .shimmer { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: loading 1.5s infinite; }
    @keyframes loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .ticket-card { background: linear-gradient(135deg, #007aff, #5856d6); color: white; }
</style>

@push('scripts')
<script>
const NODE_API = 'http://localhost:3000';
const urlParams = new URLSearchParams(window.location.search);
const flightId = urlParams.get('flight_id');
let currentFlight = null;
let occupiedSeats = [];
let selectedSeat = null;

document.addEventListener('DOMContentLoaded', async () => {
    if (!flightId) {
        alert('No flight selected!');
        window.location.href = '/flights/search';
        return;
    }
    loadFlightDetails();
    loadSeats();
});

async function loadSeats() {
    try {
        const res = await fetch(`${NODE_API}/api/flights/${flightId}/seats`, {
            headers: window.API_TOKEN ? { 'Authorization': 'Bearer ' + window.API_TOKEN } : {}
        });
        const data = await res.json();
        if (data.success) {
            occupiedSeats = data.occupiedSeats;
            renderSeatGrid();
        }
    } catch (err) {
        console.error('Failed to load seats', err);
    }
}

function renderSeatGrid() {
    const rows = 10;
    const cols = ['A', 'B', 'C', 'D', 'E', 'F'];
    let html = '<div class="d-inline-flex flex-column gap-2">';
    
    for (let r = 1; r <= rows; r++) {
        html += '<div class="d-flex gap-2 justify-content-center">';
        cols.forEach((c, index) => {
            if (index === 3) html += '<div style="width: 30px;"></div>'; // Aisle
            const seatNumber = `${r}${c}`;
            const isOccupied = occupiedSeats.includes(seatNumber);
            const btnClass = isOccupied ? 'btn-secondary opacity-50' : 'btn-outline-primary';
            const disabled = isOccupied ? 'disabled' : '';
            
            html += `<button type="button" class="btn ${btnClass} seat-btn fw-bold p-0" style="width:40px; height:40px;" ${disabled} onclick="selectSeat('${seatNumber}')">${seatNumber}</button>`;
        });
        html += '</div>';
    }
    html += '</div>';
    document.getElementById('seat-grid').innerHTML = html;
}

function selectSeat(seatNumber) {
    selectedSeat = seatNumber;
    document.getElementById('p-seat').value = seatNumber;
    document.getElementById('selected-seat-display').innerText = 'Seat: ' + seatNumber;
    
    document.querySelectorAll('.seat-btn').forEach(btn => {
        if (!btn.disabled) {
            btn.classList.remove('btn-primary', 'text-white');
            btn.classList.add('btn-outline-primary');
        }
    });
    
    const selectedBtn = Array.from(document.querySelectorAll('.seat-btn')).find(b => b.innerText === seatNumber);
    if (selectedBtn) {
        selectedBtn.classList.remove('btn-outline-primary');
        selectedBtn.classList.add('btn-primary', 'text-white');
    }
}

async function loadFlightDetails() {
    try {
        const res = await fetch(`${NODE_API}/api/flights/${flightId}`, {
            headers: window.API_TOKEN ? { 'Authorization': 'Bearer ' + window.API_TOKEN } : {}
        });
        currentFlight = await res.json();
        
        renderFlightSummary(currentFlight);
        document.getElementById('display-total').innerText = '$' + currentFlight.price.toLocaleString();
        document.getElementById('confirm-btn').disabled = false;
    } catch (err) {
        console.error('Failed to load flight:', err);
    }
}

function renderFlightSummary(f) {
    const container = document.getElementById('flight-summary');
    container.innerHTML = `
        <div class="card border-0 rounded-5 shadow-sm overflow-hidden ticket-card">
            <div class="p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-white-50 text-uppercase">${f.airline}</h5>
                    <span class="badge bg-white text-primary rounded-pill px-3">${f.flight_number}</span>
                </div>
                <div class="row align-items-center text-center text-lg-start">
                    <div class="col-lg-4">
                        <h1 class="display-4 fw-800 mb-0">${f.origin_airport_id.code}</h1>
                        <p class="mb-0 opacity-75">${f.origin_airport_id.city}</p>
                    </div>
                    <div class="col-lg-4 text-center py-4 py-lg-0">
                        <i class="fas fa-plane fa-3x opacity-50"></i>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <h1 class="display-4 fw-800 mb-0">${f.destination_airport_id.code}</h1>
                        <p class="mb-0 opacity-75">${f.destination_airport_id.city}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
}

document.getElementById('booking-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('confirm-btn');
    btn.disabled = true;
    btn.innerText = 'PROCESSING...';

    const activeUser = {
        _id: '{{ auth()->user()->id }}',
        role: '{{ auth()->user()->role ?? "user" }}'
    };
    const mockUserId = activeUser._id;

    const payload = {
        user_id: mockUserId,
        flight_id: flightId,
        total_price: currentFlight.price,
        passengers: [{
            first_name: document.getElementById('p-first-name').value,
            last_name: document.getElementById('p-last-name').value,
            passport_number: document.getElementById('p-passport').value,
            seat_number: document.getElementById('p-seat').value
        }]
    };

    console.log('%c 🎫 POST %c → %c /api/bookings', 'background: #ff9500; color: white; padding: 2px 6px; border-radius: 3px;', '', 'color: #007aff;', payload);

    try {
        const res = await fetch(`${NODE_API}/api/bookings`, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                ...(window.API_TOKEN ? { 'Authorization': 'Bearer ' + window.API_TOKEN } : {})
            },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        
        if (data.success) {
            console.log('%c ✅ BOOKING SUCCESS ', 'background: #34c759; color: white; padding: 2px 6px; border-radius: 3px;');
            
            // Redirect to Payment Gateway
            window.location.href = `/payments/${data.booking_id}/process`;
        }
    } catch (err) {
        console.error('Booking failed:', err);
        alert('Booking failed. Check console.');
        btn.disabled = false;
        btn.innerText = 'CONFIRM RESERVATION';
    }
});
</script>
@endpush
@endsection
