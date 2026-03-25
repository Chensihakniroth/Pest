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

    <!-- API Status Badge -->
    <div class="mb-4 text-center">
        <div id="sync-status" class="badge bg-light text-secondary rounded-pill px-3 py-2 border-0 fw-bold">
            <i class="fas fa-sync fa-spin me-1"></i> SYNCING WITH NODE.JS...
        </div>
    </div>

    <!-- Booking List Container -->
    <div id="booking-container" class="row g-4">
        <!-- Skeleton Loading State -->
        <div class="col-lg-6"><div class="shimmer rounded-5" style="height: 350px;"></div></div>
        <div class="col-lg-6"><div class="shimmer rounded-5" style="height: 350px;"></div></div>
    </div>
</div>

<style>
    .shimmer { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: loading 1.5s infinite; }
    @keyframes loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .trip-card { transition: transform 0.3s ease; border-radius: 25px; }
    .trip-card:hover { transform: translateY(-5px); }
</style>

@push('scripts')
<script>
const NODE_API = 'http://localhost:3000';

document.addEventListener('DOMContentLoaded', async () => {
    console.clear();
    console.log('%c 🎫 JOURNEY MODULE INITIALIZED ', 'background: #1c1c1e; color: #007aff; font-weight: bold; padding: 5px; border-radius: 5px;');
    loadMyBookings();
});

async function loadMyBookings() {
    try {
        const currentUserId = '{{ auth()->user()->id }}';
        
        const allBookings = await apiCall('/api/bookings');
        const myBookings = allBookings.filter(b => b.user === currentUserId || (b.user && b.user._id === currentUserId));

        const statusBadge = document.getElementById('sync-status');
        statusBadge.innerHTML = `<i class="fas fa-check-circle me-1"></i> NODE.JS SYNCED (${myBookings.length} Trips)`;
        statusBadge.className = 'badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border-0 fw-bold';

        renderBookings(myBookings);
    } catch (err) {
        console.error('Failed to load trips:', err);
        document.getElementById('sync-status').innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i> SYNC FAILED';
        document.getElementById('sync-status').className = 'badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 border-0 fw-bold';
    }
}

function renderBookings(bookings) {
    const container = document.getElementById('booking-container');
    
    if (bookings.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="card p-5 text-center border-0 shadow-sm" style="border-radius: 30px;">
                    <i class="fas fa-passport fa-4x text-light mb-4"></i>
                    <h3 class="fw-800 text-dark">No Active Trips</h3>
                    <p class="text-secondary lead">Your passport is waiting for its first SkyConnect stamp.</p>
                </div>
            </div>`;
        return;
    }

    container.innerHTML = bookings.map(b => `
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm overflow-hidden h-100 trip-card">
                <div class="p-4 d-flex justify-content-between align-items-center" style="background: rgba(0, 122, 255, 0.05);">
                    <div>
                        <span class="badge bg-white text-primary border rounded-pill px-3 py-2 mb-2 small fw-bold">ECONOMY</span>
                        <div class="small text-secondary fw-bold">REF: ${b.booking_reference}</div>
                    </div>
                    <div>
                        <span class="badge bg-${b.status === 'confirmed' ? 'success' : 'secondary'} rounded-pill px-3 py-2 fw-bold text-uppercase">${b.status}</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center text-center mb-4">
                        <div style="flex: 1;">
                            <h2 class="fw-800 text-dark mb-0">${b.flight?.origin_airport_id?.code || '???'}</h2>
                            <p class="small text-secondary mb-0">${b.flight?.origin_airport_id?.city || 'Unknown'}</p>
                        </div>
                        <div class="px-3 opacity-25"><i class="fas fa-plane text-primary"></i></div>
                        <div style="flex: 1;">
                            <h2 class="fw-800 text-dark mb-0">${b.flight?.destination_airport_id?.code || '???'}</h2>
                            <p class="small text-secondary mb-0">${b.flight?.destination_airport_id?.city || 'Unknown'}</p>
                        </div>
                    </div>
                    <div class="row g-3 py-3 border-top border-bottom mb-4">
                        <div class="col-6">
                            <p class="small text-muted text-uppercase mb-1 fw-bold">Departure</p>
                            <p class="small fw-bold text-dark mb-0">${new Date(b.flight?.departure_time).toLocaleDateString()} ${new Date(b.flight?.departure_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="small text-muted text-uppercase mb-1 fw-bold">Fare Paid</p>
                            <p class="small fw-bold text-dark mb-0">$${b.total_price.toLocaleString()}</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/bookings/${b._id}" class="btn btn-light flex-grow-1 rounded-pill fw-bold border">Details</a>
                        ${b.status === 'confirmed' ? `<a href="/bookings/${b._id}/boarding-pass" class="btn btn-primary flex-grow-1 rounded-pill fw-bold shadow-sm">Boarding Pass</a>` : ''}
                        ${b.status === 'pending_payment' ? `<a href="/payments/${b._id}/process" class="btn btn-warning flex-grow-1 rounded-pill fw-bold shadow-sm text-dark">Pay Now</a>` : ''}
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

async function apiCall(endpoint) {
    const url = NODE_API + endpoint;
    console.log(`%c 200 %c GET %c → %c ${url}`, `background: #1c1c1e; color: #34c759; padding: 2px 6px; border-radius: 3px; font-weight: bold;`, `background: #34c759; color: white; padding: 2px 6px; border-radius: 3px; font-weight: bold;`, 'color: #8e8e93;', 'color: #007aff; text-decoration: underline;');
    
    const options = { headers: {} };
    if (window.API_TOKEN) options.headers['Authorization'] = 'Bearer ' + window.API_TOKEN;
    
    const res = await fetch(url, options);
    return await res.json();
}
</script>
@endpush
@endsection
