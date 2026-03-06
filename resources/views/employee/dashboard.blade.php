@extends('layouts.app')

@section('title', 'Staff Portal - SkyConnect')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-5 reveal">
        <div>
            <h6 class="text-primary fw-bold text-uppercase small mb-1" style="letter-spacing: 2px;">Management Console</h6>
            <h1 class="display-5 fw-800 text-dark mb-0" style="letter-spacing: -1.5px;">Staff Portal</h1>
        </div>
        <div class="d-none d-md-block">
            <div class="mirror-glass p-2 px-4 rounded-pill">
                <span class="text-secondary small fw-bold">SYSTEM STATUS:</span>
                <span class="text-success small fw-bold ms-2"><i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i> OPERATIONAL</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats Overhaul -->
    <div class="row mb-5 g-4">
        <div class="col-md-4">
            <div class="card p-4 border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-secondary small fw-bold mb-2">REVENUE GENERATED</h6>
                        <h2 class="fw-800 mb-0">${{ number_format($stats['total_revenue'] ?? 0, 0) }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4">
                        <i class="fas fa-chart-line text-primary fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-secondary small fw-bold mb-2">ACTIVE BOOKINGS</h6>
                        <h2 class="fw-800 mb-0 text-success">{{ $stats['active_bookings'] ?? 0 }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-4">
                        <i class="fas fa-ticket-alt text-success fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-secondary small fw-bold mb-2">GLOBAL CLIENTS</h6>
                        <h2 class="fw-800 mb-0">{{ $stats['total_users'] ?? 0 }}</h2>
                    </div>
                    <div class="bg-dark bg-opacity-10 p-3 rounded-4">
                        <i class="fas fa-users text-dark fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Tabs -->
    <div class="card border-0 mb-5">
        <div class="card-header bg-transparent border-0 p-3">
            <ul class="nav nav-pills nav-justified" id="dashboardTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active py-3 rounded-pill" data-bs-toggle="tab" data-bs-target="#users" type="button">
                        <i class="fas fa-user-friends me-2"></i> Client List
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-3 rounded-pill" data-bs-toggle="tab" data-bs-target="#bookings" type="button">
                        <i class="fas fa-list-check me-2"></i> Bookings
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link py-3 rounded-pill" data-bs-toggle="tab" data-bs-target="#flights" type="button">
                        <i class="fas fa-plane-up me-2"></i> Flight Ops
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4 pt-0">
            <div class="tab-content" id="dashboardTabsContent">

                <!-- CUSTOMER LIST REVAMP (Users Tab) -->
                <div class="tab-pane fade show active" id="users" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-4 mt-2">
                        <h4 class="fw-800 text-dark mb-0">Client Network</h4>
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control border-start-0 rounded-end-pill shadow-none" placeholder="Search clients...">
                        </div>
                    </div>

                    <div class="row g-3">
                        @foreach ($users as $user)
                            <div class="col-xl-4 col-md-6">
                                <div class="premium-list-item h-100 flex-column align-items-stretch">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-circle me-3 shadow-sm" style="width: 50px; height: 50px; font-size: 1.2rem; background: linear-gradient(135deg, var(--sc-primary), #5856d6);">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-0 text-dark">{{ $user->name }}</h6>
                                            <p class="small text-secondary mb-0">{{ $user->email }}</p>
                                        </div>
                                        <div>
                                            @if($user->role === 'admin')
                                                <span class="badge badge-ios bg-danger bg-opacity-10 text-danger border-0">ADMIN</span>
                                            @elseif($user->role === 'employee')
                                                <span class="badge badge-ios bg-warning bg-opacity-10 text-warning border-0">STAFF</span>
                                            @else
                                                <span class="badge badge-ios bg-primary bg-opacity-10 text-primary border-0">CLIENT</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center">
                                        <div class="small text-secondary">
                                            <i class="far fa-calendar-alt me-1"></i> Joined {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle p-0" style="width: 30px; height: 30px;" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu border-0 shadow-lg" style="border-radius: 12px;">
                                                <li><a class="dropdown-item small py-2" href="#"><i class="fas fa-history me-2 text-primary"></i>Travel History</a></li>
                                                <li><a class="dropdown-item small py-2" href="#"><i class="fas fa-envelope me-2 text-primary"></i>Message</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item small py-2 text-danger" href="#"><i class="fas fa-ban me-2"></i>Restrict</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Bookings Tab -->
                <div class="tab-pane fade" id="bookings" role="tabpanel">
                    <h4 class="fw-800 text-dark mb-4 mt-2">Global Reservation Stream</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead class="bg-light bg-opacity-50">
                                <tr>
                                    <th class="border-0 py-3 rounded-start-pill ps-4">REF ID</th>
                                    <th class="border-0">PASSENGER</th>
                                    <th class="border-0 text-center">CLASS</th>
                                    <th class="border-0">FARE</th>
                                    <th class="border-0 text-center">STATUS</th>
                                    <th class="border-0 rounded-end-pill pe-4 text-end">COMMAND</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr class="reveal border-bottom">
                                        <td class="ps-4"><code class="text-primary fw-bold">{{ $booking->booking_reference }}</code></td>
                                        <td>
                                            <div class="fw-bold">{{ $booking->user->name }}</div>
                                            <div class="small text-secondary">{{ $booking->flight->flight_number }} | {{ $booking->flight->originAirport->code }} → {{ $booking->flight->destinationAirport->code }}</div>
                                        </td>
                                        <td class="text-center"><span class="badge badge-ios border bg-white text-dark">{{ $booking->fare_class }}</span></td>
                                        <td class="fw-bold">${{ number_format($booking->total_price, 2) }}</td>
                                        <td class="text-center">
                                            @if($booking->status === 'confirmed')
                                                <span class="badge badge-ios bg-success bg-opacity-10 text-success">Active</span>
                                            @else
                                                <span class="badge badge-ios bg-secondary bg-opacity-10 text-secondary">{{ $booking->status }}</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            @if($booking->status === 'confirmed')
                                                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 rounded-pill">REVOKE</button>
                                                </form>
                                            @else
                                                <span class="text-muted small">CLOSED</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Flights Tab -->
                <div class="tab-pane fade" id="flights" role="tabpanel">
                    <h4 class="fw-800 text-dark mb-4 mt-2">Active Fleet Status</h4>
                    <div class="row g-4">
                        @foreach($flights as $flight)
                            <div class="col-lg-6">
                                <div class="premium-list-item p-4">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="badge bg-primary px-3 py-2 rounded-pill me-2">{{ $flight->flight_number }}</span>
                                            <span class="fw-bold text-dark">{{ $flight->airline }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center px-2">
                                            <div class="text-center">
                                                <h4 class="fw-800 mb-0 text-dark">{{ $flight->originAirport->code }}</h4>
                                                <p class="small text-secondary mb-0">{{ $flight->originAirport->city }}</p>
                                            </div>
                                            <div class="px-4 text-secondary"><i class="fas fa-long-arrow-alt-right fa-2x"></i></div>
                                            <div class="text-center">
                                                <h4 class="fw-800 mb-0 text-dark">{{ $flight->destinationAirport->code }}</h4>
                                                <p class="small text-secondary mb-0">{{ $flight->destinationAirport->city }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ms-4 ps-4 border-start d-flex flex-column align-items-end justify-content-center" style="min-width: 120px;">
                                        <div class="small fw-bold text-secondary mb-1">LOAD FACTOR</div>
                                        <div class="fw-800 text-primary mb-2">
                                            @php $load = round((1 - ($flight->capacity / 150)) * 100); @endphp
                                            {{ max(0, $load) }}%
                                        </div>
                                        <div class="progress w-100" style="height: 6px; border-radius: 10px;">
                                            <div class="progress-bar" style="width: {{ $load }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
