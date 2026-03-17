@extends('layouts.app')

@section('title', 'SkyConnect Command - Staff Portal')

@section('content')
<div class="container-fluid py-5 px-lg-5">
    <div class="d-flex justify-content-between align-items-end mb-5 reveal">
        <div>
            <h6 class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: 3px;">SkyConnect Command</h6>
            <h1 class="display-4 fw-800 text-dark mb-0" style="letter-spacing: -1.5px;">Global Fleet Ops</h1>
        </div>
        <div class="mirror-glass p-3 px-4 rounded-pill shadow-sm bg-white bg-opacity-50" style="backdrop-filter: blur(10px);">
            <div class="d-flex align-items-center">
                <div id="api-indicator" class="bg-warning rounded-circle me-2" style="width: 10px; height: 10px;"></div>
                <span id="api-status-text" class="small fw-bold text-secondary text-uppercase">Node.js Syncing...</span>
            </div>
        </div>
    </div>

    <!-- Management Console -->
    <div class="card border-0 rounded-5 shadow-sm bg-white overflow-hidden">
        <div class="card-header bg-light bg-opacity-50 border-0 p-0">
            <ul class="nav nav-pills nav-fill" id="mgmtTabs">
                <li class="nav-item"><button class="nav-link active py-4 rounded-0 fw-bold border-0" data-bs-toggle="tab" data-bs-target="#users-panel">CLIENT NETWORK</button></li>
                <li class="nav-item"><button class="nav-link py-4 rounded-0 fw-bold border-0" data-bs-toggle="tab" data-bs-target="#bookings-panel">RESERVATIONS</button></li>
                <li class="nav-item"><button class="nav-link py-4 rounded-0 fw-bold border-0" data-bs-toggle="tab" data-bs-target="#flights-panel">FLEET STATUS</button></li>
            </ul>
        </div>

        <div class="card-body p-4 p-lg-5">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="users-panel"><div id="user-list" class="row g-4"></div></div>
                <div class="tab-pane fade" id="bookings-panel"><div class="table-responsive"><table class="table align-middle"><thead><tr><th class="ps-4">Reference</th><th>Passenger</th><th>Status</th><th class="text-end pe-4">Command</th></tr></thead><tbody id="booking-list"></tbody></table></div></div>

                <!-- FLIGHTS PANEL -->
                <div class="tab-pane fade" id="flights-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-800 text-dark mb-0">Active Fleet</h4>
                        <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" onclick="showAddFlightForm()">+ REGISTER FLIGHT</button>
                    </div>
                    
                    <!-- INSERT FORM -->
                    <div id="add-flight-form" class="card p-4 p-lg-5 rounded-5 border-0 bg-light mb-5 d-none shadow-sm">
                        <h5 class="fw-800 mb-4 text-primary">New Flight Operation</h5>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="small fw-bold text-secondary text-uppercase ms-2">Flight Number</label>
                                <input type="text" id="new-flight-num" class="form-control rounded-pill border-0 px-4 py-3" placeholder="e.g. SC101">
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-secondary text-uppercase ms-2">Airline</label>
                                <input type="text" id="new-airline" class="form-control rounded-pill border-0 px-4 py-3" placeholder="e.g. SkyConnect">
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-secondary text-uppercase ms-2">Base Price ($)</label>
                                <input type="number" id="new-price" class="form-control rounded-pill border-0 px-4 py-3" placeholder="0.00">
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-secondary text-uppercase ms-2">Capacity</label>
                                <input type="number" id="new-capacity" class="form-control rounded-pill border-0 px-4 py-3" value="150">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="small fw-bold text-secondary text-uppercase ms-2">Departure Route</label>
                                <div class="input-group">
                                    <select id="new-origin" class="form-select border-0 rounded-start-pill px-4 py-3"><option selected disabled>Origin Airport...</option></select>
                                    <input type="datetime-local" id="new-departure" class="form-control border-0 rounded-end-pill px-4 py-3">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="small fw-bold text-secondary text-uppercase ms-2">Arrival Route</label>
                                <div class="input-group">
                                    <select id="new-destination" class="form-select border-0 rounded-start-pill px-4 py-3"><option selected disabled>Destination...</option></select>
                                    <input type="datetime-local" id="new-arrival" class="form-control border-0 rounded-end-pill px-4 py-3">
                                </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button onclick="showAddFlightForm()" class="btn btn-link text-secondary text-decoration-none fw-bold me-3">CANCEL</button>
                                <button onclick="insertFlight()" class="btn btn-dark rounded-pill px-5 py-3 fw-bold shadow">SAVE TO MONGODB</button>
                            </div>
                        </div>
                    </div>

                    <div id="flight-list" class="row g-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link { color: #8e8e93; transition: all 0.3s ease; }
    .nav-pills .nav-link.active { background: white !important; color: var(--sc-primary) !important; border-bottom: 3px solid var(--sc-primary) !important; }
    .premium-user-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid rgba(0,0,0,0.05); }
    .premium-user-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
</style>

@push('scripts')
<script>
const NODE_API = 'http://localhost:3000';

document.addEventListener('DOMContentLoaded', () => {
    console.clear();
    console.log('%c ⚡ FULL CRUD MONITOR ACTIVE ', 'color: #007aff; font-weight: bold; font-size: 14px;');
    syncApi();
    loadAirportsForForm();
});

// Sleek Minimal API Call Logging
async function apiCall(endpoint, method = 'GET', body = null) {
    const url = NODE_API + endpoint;
    const colors = { 'GET': '#34c759', 'POST': '#ff9500', 'PUT': '#ff3b30', 'DELETE': '#5856d6' };
    const options = { method, headers: { 'Accept': 'application/json' } };
    if (body) { options.headers['Content-Type'] = 'application/json'; options.body = JSON.stringify(body); }

    try {
        const response = await fetch(url, options);
        const data = await response.json();
        console.log(`%c ${response.status} %c ${method} %c → %c ${url}`, 
            `background: #1c1c1e; color: ${response.status < 400 ? '#34c759' : '#ff3b30'}; padding: 2px 6px; border-radius: 3px; font-weight: bold;`,
            `background: ${colors[method] || '#8e8e93'}; color: white; padding: 2px 6px; border-radius: 3px; font-weight: bold;`, '', 'color: #007aff;');
        return data;
    } catch (err) { console.error('API Error:', err); throw err; }
}

async function loadAirportsForForm() {
    const airports = await apiCall('/api/airports');
    const options = airports.map(a => `<option value="${a._id}">${a.city} (${a.code})</option>`).join('');
    document.getElementById('new-origin').innerHTML += options;
    document.getElementById('new-destination').innerHTML += options;
}

async function syncApi() {
    try {
        const [users, flights, bookings] = await Promise.all([apiCall('/api/users'), apiCall('/api/flights'), apiCall('/api/bookings')]);
        document.getElementById('api-indicator').className = 'bg-success rounded-circle me-2';
        document.getElementById('api-status-text').innerText = 'Node.js Connected';
        renderUsers(users); renderFlights(flights); renderBookings(bookings);
    } catch (err) {
        document.getElementById('api-indicator').className = 'bg-danger rounded-circle me-2';
        document.getElementById('api-status-text').innerText = 'Backend Offline';
    }
}

function renderUsers(users) {
    document.getElementById('user-list').innerHTML = users.map(user => `
        <div class="col-xl-4 col-md-6" id="user-card-${user._id}">
            <div class="card rounded-5 p-4 border-0 bg-light h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-800 mb-0 text-dark">${user.name}</h6>
                    <button onclick="deleteUser('${user._id}')" class="btn btn-sm btn-link text-danger p-0"><i class="fas fa-trash-alt"></i></button>
                </div>
                <p class="small text-secondary mb-3">${user.email}</p>
                <button onclick="toggleRestriction('${user._id}')" class="btn btn-sm ${user.is_active ? 'btn-outline-dark' : 'btn-danger'} rounded-pill w-100 py-2">${user.is_active ? 'RESTRICT' : 'UNRESTRICT'}</button>
            </div>
        </div>
    `).join('');
}

function renderBookings(bookings) {
    document.getElementById('booking-list').innerHTML = bookings.map(b => `
        <tr class="border-bottom">
            <td class="ps-4"><code>${b.booking_reference}</code></td>
            <td>${b.user?.name || 'Guest'}</td>
            <td><span class="badge bg-${b.status === 'confirmed' ? 'success' : 'secondary'} bg-opacity-10 text-${b.status === 'confirmed' ? 'success' : 'secondary'} rounded-pill px-3">${b.status}</span></td>
            <td class="pe-4 text-end">${b.status === 'confirmed' ? `<button onclick="cancelBooking('${b._id}')" class="btn btn-link text-danger p-0 text-decoration-none fw-bold small">REVOKE</button>` : '<span class="small text-muted">CLOSED</span>'}</td>
        </tr>
    `).join('');
}

function renderFlights(flights) {
    document.getElementById('flight-list').innerHTML = flights.map(f => `
        <div class="col-lg-6" id="flight-card-${f._id}">
            <div class="card border-0 rounded-5 p-4 shadow-sm bg-light">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-primary rounded-pill px-3">${f.flight_number}</span>
                    <button onclick="deleteFlight('${f._id}')" class="btn btn-sm btn-link text-danger p-0 fw-bold small">DELETE</button>
                </div>
                <h5 class="fw-800 text-dark mb-1">${f.airline}</h5>
                <p class="small text-secondary mb-0">${f.origin_airport_id?.city || '???'} to ${f.destination_airport_id?.city || '???'}</p>
            </div>
        </div>
    `).join('');
}

// --- CRUD ACTIONS ---
function showAddFlightForm() { document.getElementById('add-flight-form').classList.toggle('d-none'); }

async function insertFlight() {
    const payload = {
        flight_number: document.getElementById('new-flight-num').value,
        airline: document.getElementById('new-airline').value,
        price: document.getElementById('new-price').value,
        capacity: document.getElementById('new-capacity').value,
        origin_airport_id: document.getElementById('new-origin').value,
        destination_airport_id: document.getElementById('new-destination').value,
        departure_time: document.getElementById('new-departure').value,
        arrival_time: document.getElementById('new-arrival').value
    };

    try {
        const data = await apiCall('/api/flights', 'POST', payload);
        if (data.success) {
            alert('Flight Registered Successfully! (✧ω✧)');
            document.getElementById('add-flight-form').classList.add('d-none');
            syncApi();
        } else {
            alert('Error: ' + data.error);
        }
    } catch (err) { alert('Validation Failed. Check console.'); }
}

async function toggleRestriction(id) { await apiCall(`/api/users/${id}/toggle-restriction`, 'POST'); syncApi(); }
async function cancelBooking(id) { await apiCall(`/api/bookings/${id}`, 'PUT', { status: 'cancelled' }); syncApi(); }
async function deleteFlight(id) { if(confirm('Delete flight?')) { await apiCall(`/api/flights/${id}`, 'DELETE'); syncApi(); } }
async function deleteUser(id) { if(confirm('Permanently delete user?')) { await apiCall(`/api/users/${id}`, 'DELETE'); syncApi(); } }
</script>
@endpush
@endsection
