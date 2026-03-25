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

    <!-- Stats Overview -->
    <div class="row g-4 mb-5 reveal">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-5 p-4 shadow-sm bg-white h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 text-primary me-3"><i class="fas fa-users fa-lg"></i></div>
                    <div>
                        <h6 class="text-secondary small fw-bold text-uppercase mb-1">Total Clients</h6>
                        <h3 class="fw-800 mb-0" id="stat-total-users">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-5 p-4 shadow-sm bg-white h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 text-success me-3"><i class="fas fa-dollar-sign fa-lg"></i></div>
                    <div>
                        <h6 class="text-secondary small fw-bold text-uppercase mb-1">Revenue</h6>
                        <h3 class="fw-800 mb-0" id="stat-revenue">$0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-5 p-4 shadow-sm bg-white h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 text-warning me-3"><i class="fas fa-plane fa-lg"></i></div>
                    <div>
                        <h6 class="text-secondary small fw-bold text-uppercase mb-1">Active Fleet</h6>
                        <h3 class="fw-800 mb-0" id="stat-total-flights">0</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 rounded-5 p-4 shadow-sm bg-white h-100">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-4 text-info me-3"><i class="fas fa-ticket-alt fa-lg"></i></div>
                    <div>
                        <h6 class="text-secondary small fw-bold text-uppercase mb-1">Bookings</h6>
                        <h3 class="fw-800 mb-0" id="stat-total-bookings">0</h3>
                    </div>
                </div>
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
                <div class="tab-pane fade show active" id="users-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-800 text-dark mb-0">Member Directory</h4>
                        <div class="input-group w-auto">
                            <span class="input-group-text bg-light border-0 rounded-start-pill ps-4"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="user-search" class="form-control bg-light border-0 rounded-end-pill px-3" placeholder="Search users..." onkeyup="filterData('users')">
                        </div>
                    </div>
                    <div id="user-list" class="row g-4 mb-4"></div>
                    <div id="user-pagination" class="d-flex justify-content-center gap-2 mt-4"></div>
                </div>
                
                <div class="tab-pane fade" id="bookings-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-800 text-dark mb-0">Global Stream</h4>
                        <div class="input-group w-auto">
                            <span class="input-group-text bg-light border-0 rounded-start-pill ps-4"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="booking-search" class="form-control bg-light border-0 rounded-end-pill px-3" placeholder="Search reference..." onkeyup="filterData('bookings')">
                        </div>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead><tr><th class="ps-4">Reference</th><th>Passenger</th><th>Status</th><th class="text-end pe-4">Command</th></tr></thead>
                            <tbody id="booking-list"></tbody>
                        </table>
                    </div>
                    <div id="booking-pagination" class="d-flex justify-content-center gap-2 mt-4"></div>
                </div>

                <!-- FLIGHTS PANEL -->
                <div class="tab-pane fade" id="flights-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-4">
                            <h4 class="fw-800 text-dark mb-0">Active Fleet</h4>
                            <div class="input-group w-auto">
                                <span class="input-group-text bg-light border-0 rounded-start-pill ps-4"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" id="flight-search" class="form-control bg-light border-0 rounded-end-pill px-3" placeholder="Search number..." onkeyup="filterData('flights')">
                            </div>
                        </div>
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

                    <div id="flight-list" class="row g-4 mb-4"></div>
                    <div id="flight-pagination" class="d-flex justify-content-center gap-2 mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link { color: #8e8e93; transition: all 0.3s ease; }
    .nav-pills .nav-link.active { background: white !important; color: var(--sc-primary) !important; border-bottom: 3px solid var(--sc-primary) !important; }
    
    /* Interactive Card Enhancements */
    .premium-user-card, .premium-flight-card { 
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
        border: 1px solid rgba(0,0,0,0.05); 
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
    }
    .premium-user-card:hover, .premium-flight-card:hover { 
        transform: translateY(-8px) scale(1.02); 
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; 
        border-color: rgba(0, 122, 255, 0.2);
    }
    
    /* Beautiful Table Styling */
    .table-hover-custom tbody tr { transition: all 0.2s ease; cursor: pointer; }
    .table-hover-custom tbody tr:hover { background-color: rgba(0, 122, 255, 0.03) !important; transform: scale(1.01); }
    .table-hover-custom td { vertical-align: middle; border-bottom: 1px solid rgba(0,0,0,0.05); padding: 1.2rem 1rem; }
    
    /* Status Badge Glows */
    .badge-glow-success { box-shadow: 0 0 10px rgba(52, 199, 89, 0.4); }
    .badge-glow-secondary { box-shadow: 0 0 10px rgba(142, 142, 147, 0.4); }
    
    /* Glassmorphism Header */
    .glass-header { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(15px); border-bottom: 1px solid rgba(0,0,0,0.05); }
</style>

@push('scripts')
<script>
const NODE_API = 'http://localhost:3000';
const ITEMS_PER_PAGE = 6;

let state = {
    users: [],
    flights: [],
    bookings: [],
    filtered: {
        users: [],
        flights: [],
        bookings: []
    },
    pages: {
        users: 1,
        flights: 1,
        bookings: 1
    }
};

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
    if (window.API_TOKEN) options.headers['Authorization'] = 'Bearer ' + window.API_TOKEN;
    if (body) { options.headers['Content-Type'] = 'application/json'; options.body = JSON.stringify(body); }

    try {
        const response = await fetch(url, options);
        const data = await response.json();
        console.log(`%c ${response.status} %c ${method} %c → %c ${url}`, 
            `background: #1c1c1e; color: ${response.status < 400 ? '#34c759' : '#ff3b30'}; padding: 2px 6px; border-radius: 3px; font-weight: bold;`,
            `background: ${colors[method] || '#8e8e93'}; color: white; padding: 2px 6px; border-radius: 3px; font-weight: bold;`, '', 'color: #007aff;');
            
        if (!response.ok) {
            console.error('API Error Response:', data);
            throw new Error(data.error || 'API Request Failed');
        }
        return data;
    } catch (err) { console.error('API Call Failed:', err); throw err; }
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
        
        state.users = users;
        state.flights = flights;
        state.bookings = bookings;
        
        state.filtered.users = [...users];
        state.filtered.flights = [...flights];
        state.filtered.bookings = [...bookings];

        updateStats();
        renderAll();
    } catch (err) {
        document.getElementById('api-indicator').className = 'bg-danger rounded-circle me-2';
        document.getElementById('api-status-text').innerText = 'Backend Offline';
    }
}

function updateStats() {
    document.getElementById('stat-total-users').innerText = state.users.length;
    document.getElementById('stat-total-flights').innerText = state.flights.length;
    document.getElementById('stat-total-bookings').innerText = state.bookings.length;
    
    const revenue = state.bookings.filter(b => b.status === 'confirmed').reduce((acc, b) => acc + (b.total_price || 0), 0);
    document.getElementById('stat-revenue').innerText = '$' + revenue.toLocaleString();
}

function filterData(type) {
    const query = document.getElementById(`${type.slice(0, -1)}-search`).value.toLowerCase();
    
    if (type === 'users') {
        state.filtered.users = state.users.filter(u => u.name.toLowerCase().includes(query) || u.email.toLowerCase().includes(query));
    } else if (type === 'flights') {
        state.filtered.flights = state.flights.filter(f => f.flight_number.toLowerCase().includes(query) || f.airline.toLowerCase().includes(query));
    } else if (type === 'bookings') {
        state.filtered.bookings = state.bookings.filter(b => b.booking_reference.toLowerCase().includes(query) || (b.user?.name || '').toLowerCase().includes(query));
    }
    
    state.pages[type] = 1;
    if (type === 'users') renderUsers();
    if (type === 'flights') renderFlights();
    if (type === 'bookings') renderBookings();
}

function renderAll() {
    renderUsers();
    renderFlights();
    renderBookings();
}

function paginate(items, page, size) {
    return items.slice((page - 1) * size, page * size);
}

function renderPaginationControls(type, totalItems) {
    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
    const currentPage = state.pages[type];
    const container = document.getElementById(`${type.slice(0, -1)}-pagination`);
    
    if (totalPages <= 1) {
        container.innerHTML = '';
        return;
    }

    let html = `
        <button class="btn btn-outline-primary rounded-pill px-4 fw-bold" ${currentPage === 1 ? 'disabled' : ''} onclick="changePage('${type}', ${currentPage - 1})">
            <i class="fas fa-chevron-left me-2"></i>PREV
        </button>
        <span class="align-self-center fw-800 text-dark mx-3">PAGE ${currentPage} / ${totalPages}</span>
        <button class="btn btn-outline-primary rounded-pill px-4 fw-bold" ${currentPage === totalPages ? 'disabled' : ''} onclick="changePage('${type}', ${currentPage + 1})">
            NEXT<i class="fas fa-chevron-right ms-2"></i>
        </button>
    `;
    container.innerHTML = html;
}

function changePage(type, newPage) {
    state.pages[type] = newPage;
    if (type === 'users') renderUsers();
    if (type === 'flights') renderFlights();
    if (type === 'bookings') renderBookings();
}

function renderUsers() {
    const users = paginate(state.filtered.users, state.pages.users, ITEMS_PER_PAGE);
    document.getElementById('user-list').innerHTML = users.map(user => {
        const roleColor = user.role === 'admin' ? 'danger' : (user.role === 'employee' ? 'primary' : 'secondary');
        return `
        <div class="col-xl-4 col-md-6" id="user-card-${user._id}">
            <div class="card rounded-5 p-4 border-0 premium-user-card h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-800 mb-1 text-dark d-flex align-items-center gap-2">
                            ${user.name} 
                            <span class="badge bg-${roleColor} bg-opacity-10 text-${roleColor} small rounded-pill px-2 py-1">${user.role ? user.role.toUpperCase() : 'USER'}</span>
                            ${user.is_active ? '' : '<span class="badge bg-danger text-white small rounded-pill px-2 py-1">RESTRICTED</span>'}
                        </h5>
                        <p class="small text-secondary mb-0"><i class="fas fa-envelope text-primary opacity-50 me-2"></i>${user.email}</p>
                    </div>
                    <div class="d-flex gap-1 bg-white rounded-pill shadow-sm p-1">
                        <button onclick="changeUserRole('${user._id}', '${user.role || 'user'}')" class="btn btn-sm btn-light rounded-circle p-2 text-primary" title="Change Role" style="width:32px; height:32px;"><i class="fas fa-user-edit"></i></button>
                        <button onclick="deleteUser('${user._id}')" class="btn btn-sm btn-light rounded-circle p-2 text-danger" title="Delete User" style="width:32px; height:32px;"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                <div class="mt-auto pt-3 border-top">
                    <button onclick="toggleRestriction('${user._id}')" class="btn btn-sm ${user.is_active ? 'btn-outline-dark' : 'btn-danger'} rounded-pill w-100 py-2 fw-bold shadow-sm transition-all">
                        <i class="fas ${user.is_active ? 'fa-ban' : 'fa-check-circle'} me-2"></i>${user.is_active ? 'RESTRICT ACCOUNT' : 'UNRESTRICT ACCOUNT'}
                    </button>
                </div>
            </div>
        </div>
    `}).join('');
    renderPaginationControls('users', state.filtered.users.length);
}

function renderBookings() {
    const bookings = paginate(state.filtered.bookings, state.pages.bookings, ITEMS_PER_PAGE);
    document.getElementById('booking-list').className = 'table-hover-custom';
    document.getElementById('booking-list').innerHTML = bookings.map(b => `
        <tr>
            <td class="ps-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3 text-primary">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div>
                        <code class="fs-6 fw-bold text-dark">${b.booking_reference}</code><br>
                        <span class="small text-secondary fw-bold"><i class="fas fa-plane text-primary opacity-50 me-1"></i>Flight ${b.flight?.flight_number || 'N/A'}</span>
                    </div>
                </div>
            </td>
            <td>
                <span class="fw-bold text-dark">${b.user?.name || 'Guest User'}</span><br>
                <span class="badge bg-success bg-opacity-10 text-success fw-bold border border-success border-opacity-25 mt-1">$${b.total_price ? b.total_price.toLocaleString() : '0'}</span>
            </td>
            <td>
                <span class="badge bg-${b.status === 'confirmed' ? 'success' : 'secondary'} text-white rounded-pill px-3 py-2 fw-bold text-uppercase badge-glow-${b.status === 'confirmed' ? 'success' : 'secondary'}">
                    <i class="fas ${b.status === 'confirmed' ? 'fa-check-circle' : 'fa-times-circle'} me-1"></i>${b.status}
                </span>
            </td>
            <td class="pe-4 text-end">
                <div class="btn-group shadow-sm rounded-pill bg-white p-1">
                    <a href="/bookings/${b._id}" class="btn btn-sm btn-light rounded-pill px-3 text-primary fw-bold" title="View Details">VIEW</a>
                    ${b.status === 'confirmed' 
                        ? `<button onclick="cancelBooking('${b._id}')" class="btn btn-sm btn-light rounded-pill px-3 text-warning fw-bold border-start" title="Revoke Booking">REVOKE</button>` 
                        : `<button onclick="confirmBooking('${b._id}')" class="btn btn-sm btn-light rounded-pill px-3 text-success fw-bold border-start" title="Confirm Booking">CONFIRM</button>`
                    }
                    <button onclick="deleteBooking('${b._id}')" class="btn btn-sm btn-light rounded-circle ms-1 text-danger px-2" title="Delete Booking"><i class="fas fa-trash"></i></button>
                </div>
            </td>
        </tr>
    `).join('');
    renderPaginationControls('bookings', state.filtered.bookings.length);
}

function renderFlights() {
    const flights = paginate(state.filtered.flights, state.pages.flights, ITEMS_PER_PAGE);
    document.getElementById('flight-list').innerHTML = flights.map(f => `
        <div class="col-lg-6" id="flight-card-${f._id}">
            <div class="card border-0 rounded-5 p-0 shadow-sm premium-flight-card overflow-hidden h-100">
                <div class="p-4 glass-header d-flex justify-content-between align-items-center">
                    <span class="badge bg-primary text-white rounded-pill px-3 py-2 fw-bold shadow-sm fs-6"><i class="fas fa-plane-departure me-2"></i>${f.flight_number}</span>
                    <button onclick="deleteFlight('${f._id}')" class="btn btn-sm btn-white rounded-circle shadow-sm text-danger p-2" style="width:35px; height:35px;"><i class="fas fa-trash-alt"></i></button>
                </div>
                <div class="card-body p-4 pt-3">
                    <h4 class="fw-800 text-dark mb-4 text-center">${f.airline}</h4>
                    <div class="d-flex justify-content-between align-items-center position-relative">
                        <div class="text-center w-50 pe-3">
                            <h2 class="display-6 fw-900 text-dark mb-0">${f.origin_airport_id?.code || '???'}</h2>
                            <p class="small text-secondary fw-bold text-uppercase mt-1">${f.origin_airport_id?.city || 'Unknown'}</p>
                        </div>
                        
                        <!-- Flight Path Graphic -->
                        <div class="position-absolute top-50 start-50 translate-middle w-50 px-4">
                            <div class="d-flex align-items-center w-100">
                                <div class="rounded-circle bg-primary opacity-25" style="width:8px; height:8px;"></div>
                                <div class="flex-grow-1 border-bottom border-2 border-primary border-dashed opacity-25 mx-1"></div>
                                <i class="fas fa-plane text-primary fs-5"></i>
                                <div class="flex-grow-1 border-bottom border-2 border-primary border-dashed opacity-25 mx-1"></div>
                                <div class="rounded-circle border border-2 border-primary opacity-25" style="width:8px; height:8px;"></div>
                            </div>
                        </div>

                        <div class="text-center w-50 ps-3">
                            <h2 class="display-6 fw-900 text-dark mb-0">${f.destination_airport_id?.code || '???'}</h2>
                            <p class="small text-secondary fw-bold text-uppercase mt-1">${f.destination_airport_id?.city || 'Unknown'}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-light p-3 border-top mt-auto d-flex justify-content-around text-center">
                    <div>
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 0.7rem;">Capacity</small>
                        <div class="fw-bold text-dark"><i class="fas fa-users text-primary me-1"></i>${f.capacity || '150'}</div>
                    </div>
                    <div class="border-end"></div>
                    <div>
                        <small class="text-secondary text-uppercase fw-bold" style="font-size: 0.7rem;">Base Price</small>
                        <div class="fw-bold text-success"><i class="fas fa-tag me-1"></i>$${f.price ? f.price.toLocaleString() : '0'}</div>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
    renderPaginationControls('flights', state.filtered.flights.length);
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
async function changeUserRole(id, currentRole) {
    const newRole = prompt(`Change role for user (current: ${currentRole}). Enter new role (admin, employee, user):`, currentRole);
    if (newRole && ['admin', 'employee', 'user'].includes(newRole.toLowerCase())) {
        await apiCall(`/api/users/${id}`, 'PUT', { role: newRole.toLowerCase() });
        syncApi();
    } else if (newRole) {
        alert('Invalid role! Please enter admin, employee, or user.');
    }
}
async function cancelBooking(id) { await apiCall(`/api/bookings/${id}`, 'PUT', { status: 'cancelled' }); syncApi(); }
async function confirmBooking(id) { await apiCall(`/api/bookings/${id}`, 'PUT', { status: 'confirmed' }); syncApi(); }
async function deleteBooking(id) { if(confirm('Permanently delete this booking?')) { await apiCall(`/api/bookings/${id}`, 'DELETE'); syncApi(); } }
async function deleteFlight(id) { if(confirm('Delete flight?')) { await apiCall(`/api/flights/${id}`, 'DELETE'); syncApi(); } }
async function deleteUser(id) { if(confirm('Permanently delete user?')) { await apiCall(`/api/users/${id}`, 'DELETE'); syncApi(); } }
</script>
@endpush
@endsection
