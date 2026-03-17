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
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase ms-2">First Name</label>
                            <input type="text" id="p-first-name" class="form-control border-0 bg-light rounded-pill py-3 px-4 shadow-none fw-bold" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary text-uppercase ms-2">Last Name</label>
                            <input type="text" id="p-last-name" class="form-control border-0 bg-light rounded-pill py-3 px-4 shadow-none fw-bold" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary text-uppercase ms-2">Passport Number</label>
                            <input type="text" id="p-passport" class="form-control border-0 bg-light rounded-pill py-3 px-4 shadow-none fw-bold" placeholder="A1234567" required>
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

document.addEventListener('DOMContentLoaded', async () => {
    if (!flightId) {
        alert('No flight selected!');
        window.location.href = '/flights/search';
        return;
    }
    loadFlightDetails();
});

async function loadFlightDetails() {
    try {
        const res = await fetch(`${NODE_API}/api/flights/${flightId}`);
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

    // In a real app, user_id would come from the auth session.
    // For this demo, we'll fetch the first user.
    const usersRes = await fetch(`${NODE_API}/api/users`);
    const users = await usersRes.json();
    const activeUser = users[0]; // This is the user we are using for the demo
    const mockUserId = activeUser?._id;

    const payload = {
        user_id: mockUserId,
        flight_id: flightId,
        total_price: currentFlight.price,
        passengers: [{
            first_name: document.getElementById('p-first-name').value,
            last_name: document.getElementById('p-last-name').value,
            passport_number: document.getElementById('p-passport').value
        }]
    };

    console.log('%c 🎫 POST %c → %c /api/bookings', 'background: #ff9500; color: white; padding: 2px 6px; border-radius: 3px;', '', 'color: #007aff;', payload);

    try {
        const res = await fetch(`${NODE_API}/api/bookings`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        
        if (data.success) {
            console.log('%c ✅ BOOKING SUCCESS ', 'background: #34c759; color: white; padding: 2px 6px; border-radius: 3px;');
            alert(`RESERVATION SUCCESS!\nReference: ${data.booking_reference}`);
            
            // Smart Redirection
            if (activeUser.role === 'admin' || activeUser.role === 'employee') {
                console.log('Redirecting to Staff Portal...');
                window.location.href = '/admin/dashboard';
            } else {
                console.log('Redirecting to My Bookings...');
                window.location.href = '/my-bookings';
            }
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
