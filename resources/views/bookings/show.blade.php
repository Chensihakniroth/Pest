@extends('layouts.app')

@section('title', 'Reservation Details - SkyConnect')

@section('content')
<div class="container py-5 px-lg-5">
    <div id="booking-details-root">
        <!-- Skeleton Loading -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="shimmer rounded-5" style="height: 600px;"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .shimmer { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: loading 1.5s infinite; }
    @keyframes loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .premium-card { border-radius: 35px; border: 0; box-shadow: 0 20px 40px rgba(0,0,0,0.05); overflow: hidden; background: white; }
    .ticket-header { background: linear-gradient(135deg, #007aff, #5856d6); color: white; padding: 40px; }
</style>

@push('scripts')
<script>
const NODE_API = 'http://localhost:3000';
const bookingId = "{{ $id }}";

document.addEventListener('DOMContentLoaded', async () => {
    console.log('%c 🎫 FETCHING RESERVATION DETAILS ', 'background: #1c1c1e; color: #007aff; font-weight: bold; padding: 5px; border-radius: 5px;');
    loadDetails();
});

async function loadMyBookings() {
    // This is a helper for the API status indicator in layouts if needed
}

async function loadDetails() {
    try {
        const response = await fetch(`${NODE_API}/api/bookings/${bookingId}`, {
            headers: window.API_TOKEN ? { 'Authorization': 'Bearer ' + window.API_TOKEN } : {}
        });
        const data = await response.json();
        
        console.log('%c 📡 API DATA: ', 'color: #34c759; font-weight: bold;', data);
        
        if (data.success) {
            renderDetails(data.booking, data.passengers);
        } else {
            document.getElementById('booking-details-root').innerHTML = `<div class="alert alert-danger">Failed to load booking: ${data.error}</div>`;
        }
    } catch (err) {
        console.error('Fetch Error:', err);
    }
}

function renderDetails(b, passengers) {
    const root = document.getElementById('booking-details-root');
    const f = b.flight;
    
    root.innerHTML = `
        <div class="row justify-content-center reveal">
            <div class="col-lg-10">
                <div class="premium-card">
                    <div class="ticket-header">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h6 class="text-white-50 small fw-bold text-uppercase mb-1">Booking Reference</h6>
                                <h3 class="fw-800 mb-0">${b.booking_reference}</h3>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-white text-primary rounded-pill px-4 py-2 fw-800">${b.status.toUpperCase()}</span>
                            </div>
                        </div>
                        <div class="row align-items-center text-center">
                            <div class="col-md-4">
                                <h1 class="display-3 fw-800 mb-0">${f.origin_airport_id.code}</h1>
                                <p class="mb-0 opacity-75">${f.origin_airport_id.city}</p>
                            </div>
                            <div class="col-md-4 py-4 py-md-0"><i class="fas fa-plane fa-3x opacity-50"></i></div>
                            <div class="col-md-4">
                                <h1 class="display-3 fw-800 mb-0">${f.destination_airport_id.code}</h1>
                                <p class="mb-0 opacity-75">${f.destination_airport_id.city}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-5">
                            <div class="col-md-7">
                                <h4 class="fw-800 text-dark mb-4">Passenger Manifest</h4>
                                ${passengers.map(p => `
                                    <div class="d-flex align-items-center p-3 mb-3 bg-light rounded-4">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3 text-primary"><i class="fas fa-user"></i></div>
                                        <div>
                                            <h6 class="fw-bold mb-0">${p.first_name} ${p.last_name}</h6>
                                            <p class="small text-secondary mb-0">Passport: ${p.passport_number || 'N/A'}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="col-md-5">
                                <div class="bg-light p-4 rounded-5">
                                    <h4 class="fw-800 text-dark mb-4">Flight Intel</h4>
                                    <div class="mb-3">
                                        <label class="small fw-bold text-secondary text-uppercase d-block mb-1">Airline</label>
                                        <p class="fw-bold text-dark mb-0">${f.airline}</p>
                                    </div>
                                    <div class="mb-3 border-top pt-3">
                                        <label class="small fw-bold text-secondary text-uppercase d-block mb-1">Departure</label>
                                        <p class="fw-bold text-dark mb-0">${new Date(f.departure_time).toLocaleString()}</p>
                                    </div>
                                    <div class="mb-3 border-top pt-3">
                                        <label class="small fw-bold text-secondary text-uppercase d-block mb-1">Total Fare Paid</label>
                                        <h3 class="fw-800 text-primary mb-0">$${b.total_price.toLocaleString()}</h3>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    ${b.status === 'confirmed' ? `
                                        <a href="/bookings/${b._id}/boarding-pass" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg">
                                            <i class="fas fa-ticket-alt me-2"></i> GET BOARDING PASS
                                        </a>
                                    ` : ''}
                                    ${b.status === 'pending_payment' ? `
                                        <a href="/payments/${b._id}/process" class="btn btn-warning w-100 py-3 rounded-pill fw-bold shadow-lg text-dark">
                                            <i class="fas fa-credit-card me-2"></i> COMPLETE PAYMENT
                                        </a>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}
</script>
@endpush
@endsection
