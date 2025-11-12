@extends('layouts.app')

@section('content')
@php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
@endphp

<div class="container-fluid px-4 py-4">
    <!-- Slim Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark fw-bold">Customer Details</h1>
            <p class="text-muted mb-0 small">Complete customer information and service history</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <!-- Customer Profile Card -->
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="fas fa-user-circle me-2 text-primary"></i>Customer Profile
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            @if($customer->hasContractExpired())
                                <span class="status-badge expired">EXPIRED</span>
                            @else
                                <span class="status-badge {{ $customer->status == 'active' ? 'active' : 'pending' }}">
                                    {{ strtoupper($customer->status) }}
                                </span>
                            @endif
                            <span class="badge bg-info">{{ $customer->customer_id }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark mb-3 small text-uppercase">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Basic Information
                                </h6>
                                <div class="info-item mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Customer ID</label>
                                    <div class="fw-bold text-dark">{{ $customer->customer_id }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Full Name</label>
                                    <div class="fw-bold text-dark">{{ $customer->name }}</div>
                                </div>
                                <div class="info-item mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Phone Number</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-phone text-primary me-2"></i>{{ $customer->phone_number }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address & Location -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark mb-3 small text-uppercase">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Location
                                </h6>
                                <div class="info-item mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Address</label>
                                    <div class="text-dark">
                                        <i class="fas fa-home text-primary me-2"></i>{{ $customer->address }}
                                    </div>
                                </div>
                                @if($customer->google_map_link)
                                <div class="info-item">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Map Location</label>
                                    <div>
                                        <a href="{{ $customer->google_map_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-2"></i>View on Maps
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Service Information -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6 class="fw-semibold text-dark mb-3 small text-uppercase">
                                <i class="fas fa-cogs me-2 text-primary"></i>Service Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Service Name</label>
                                    <div class="fw-bold text-dark">{{ $customer->service_name }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Service Type</label>
                                    <div>
                                        <span class="service-badge {{ $customer->service_type === 'host_system' ? 'host-system' : 'baiting-system' }}">
                                            {{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Service Price</label>
                                    <div class="fw-bold text-success">${{ number_format($customer->service_price, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contract Information -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6 class="fw-semibold text-dark mb-3 small text-uppercase">
                                <i class="fas fa-file-contract me-2 text-primary"></i>Contract Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Contract Start</label>
                                    <div class="fw-bold text-dark">
                                        <i class="fas fa-calendar-plus text-primary me-2"></i>{{ $customer->contract_start_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Contract End</label>
                                    @php
                                        $daysUntilExpiration = $customer->getDisplayDaysUntilExpiration();
                                        $isExpiringSoon = $customer->isContractExpiring();
                                    @endphp
                                    <div class="fw-bold {{ $isExpiringSoon ? 'text-warning' : ($customer->hasContractExpired() ? 'text-danger' : 'text-dark') }}">
                                        <i class="fas fa-calendar-minus text-primary me-2"></i>{{ $customer->contract_end_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small">Contract Status</label>
                                    <div>
                                        @php
                                            $customer->updateContractStatus();
                                        @endphp

                                        @if($customer->hasContractExpired() || $customer->status === 'expired')
                                            <span class="status-badge expired">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Expired
                                            </span>
                                            <div class="text-danger small mt-1 fw-semibold">{{ $customer->getDaysSinceExpiration() }} days ago</div>
                                        @elseif($customer->isContractExpiring())
                                            <span class="status-badge expiring">
                                                <i class="fas fa-clock me-1"></i>Expiring Soon
                                            </span>
                                        @else
                                            @if($customer->status == 'active')
                                                <span class="status-badge active">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                                <div class="text-success small mt-1 fw-semibold">{{ $customer->getDisplayDaysUntilExpiration() }} days left</div>
                                            @else
                                                <span class="status-badge pending">
                                                    <i class="fas fa-pause me-1"></i>Pending
                                                </span>
                                                <div class="text-muted small mt-1">Contract on hold</div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Contract Alert Banner -->
                            @if($customer->isContractExpiring() && !$customer->hasContractExpired())
                            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="alert-heading mb-1 fw-bold">Contract Expiring Soon!</h6>
                                        <p class="mb-0 small">
                                            This contract will expire in <strong>{{ $customer->getDisplayDaysUntilExpiration() }} days</strong>
                                            on <strong>{{ $customer->contract_end_date->format('M d, Y') }}</strong>.
                                        </p>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Comments -->
                    @if($customer->comments)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="fw-semibold text-dark mb-3 small text-uppercase">
                                <i class="fas fa-comments me-2 text-primary"></i>Additional Notes
                            </h6>
                            <div class="bg-light rounded p-3 border">
                                <p class="mb-0 text-dark small">{{ $customer->comments }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance Schedule - Fixed Scroll Version -->
            @if($customer->status == 'active' && !$customer->hasContractExpired())
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Maintenance Schedule
                        </h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                            <i class="fas fa-plus me-1"></i>Record
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @php
                        $allScheduledDates = $customer->getAllScheduledMaintenanceDates();
                    @endphp

                    @if($allScheduledDates->count() > 0)
                        <div class="maintenance-scroll-container">
                            <div class="list-group list-group-flush">
                                @foreach($allScheduledDates as $schedule)
                                    @php
                                        $isOverdue = $schedule['type'] === 'overdue';
                                        $isUpcoming = $schedule['type'] === 'upcoming';
                                        $isScheduled = $schedule['type'] === 'scheduled';
                                        $daysDiff = $schedule['days'];
                                        $isCompleted = $schedule['completed'];
                                    @endphp
                                    <div class="list-group-item list-group-item-action border-0 py-2 px-3 maintenance-item
                                        {{ $isCompleted ? 'completed' : ($isOverdue ? 'overdue' : ($isUpcoming ? 'upcoming' : '')) }}">

                                        <div class="row align-items-center g-2">
                                            <div class="col-1">
                                                <div class="fw-semibold text-dark small">#{{ $schedule['maintenance_number'] }}</div>
                                            </div>
                                            <div class="col-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="text-dark small">{{ $schedule['date']->format('M d, Y') }}</span>
                                                    @if($isCompleted)
                                                        <i class="fas fa-check-circle text-success ms-1" style="font-size: 0.7rem;"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                @if($isCompleted)
                                                    <span class="status-badge-sm active">Done</span>
                                                @elseif($isOverdue)
                                                    <span class="status-badge-sm expired">Overdue</span>
                                                @elseif($isUpcoming)
                                                    <span class="status-badge-sm expiring">Upcoming</span>
                                                @else
                                                    <span class="status-badge-sm pending">Scheduled</span>
                                                @endif
                                            </div>
                                            <div class="col-3">
                                                @if($isCompleted)
                                                    <span class="text-muted small">Completed</span>
                                                @elseif($isOverdue)
                                                    <span class="text-danger fw-semibold small">Overdue {{ abs($daysDiff) }}d</span>
                                                @elseif($isUpcoming)
                                                    <span class="text-info fw-semibold small">In {{ $daysDiff }}d</span>
                                                @else
                                                    <span class="text-muted small">In {{ $daysDiff }}d</span>
                                                @endif
                                            </div>
                                            <div class="col-3 text-end">
                                                @if(!$isCompleted)
                                                    <button type="button" class="btn btn-success btn-xs mark-done-btn"
                                                            data-date="{{ $schedule['date']->format('Y-m-d') }}">
                                                        <i class="fas fa-check me-1"></i>Mark Done
                                                    </button>
                                                @else
                                                    <span class="text-muted small">Completed</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-lg mb-3"></i>
                            <p class="mb-0 fw-semibold small">No maintenance schedule</p>
                            <small class="text-muted">Maintenance dates will be generated based on service type</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="card glass-morphism border-0 shadow-sm">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-history me-2 text-primary"></i>Maintenance History
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($maintenanceHistory->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($maintenanceHistory as $history)
                        <div class="list-group-item list-group-item-action border-0 py-3 px-4">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="fw-semibold text-dark small">{{ $history->maintenance_date->format('M d, Y') }}</div>
                                </div>
                                <div class="col-md-3">
                                    <span class="service-badge small {{ $history->service_type === 'host_system' ? 'host-system' : 'baiting-system' }}">
                                        {{ ucfirst(str_replace('_', ' ', $history->service_type)) }}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-dark small">{{ $history->performed_by ?? 'System' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-muted small">{{ $history->notes ?: 'No notes' }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-clipboard-list fa-lg mb-3"></i>
                        <p class="mb-0 fw-semibold small">No maintenance history</p>
                        <small class="text-muted">Maintenance records will appear here once added</small>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Inactive Customer Message -->
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-pause me-2 text-primary"></i>Account On Hold
                    </h5>
                </div>
                <div class="card-body text-center py-4">
                    <i class="fas fa-pause-circle fa-2x text-muted mb-3"></i>
                    <h6 class="text-muted fw-semibold mb-2">
                        @if($customer->hasContractExpired())
                            Contract Expired
                        @else
                            Customer Account is Pending
                        @endif
                    </h6>
                    <p class="text-muted mb-3 small">
                        @if($customer->hasContractExpired())
                            This contract has expired. Maintenance features are disabled until the contract is renewed.
                        @else
                            Maintenance features and contract management are available when the account status is set to Active.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        @if($customer->hasContractExpired())
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#renewModal">
                                <i class="fas fa-sync-alt me-2"></i>Renew
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Actions & Alerts -->
<div class="col-lg-4">
    <!-- Contract Alerts Card -->
    @if(($customer->status == 'active' && $customer->isContractExpiring()) || $customer->hasContractExpired())
    <div class="card glass-morphism border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent py-3 px-4 border-bottom">
            <h6 class="mb-0 fw-semibold text-dark">
                <i class="fas fa-exclamation-triangle me-2 text-primary"></i>Contract Alert
            </h6>
        </div>
        <div class="card-body p-4">
            @if($customer->hasContractExpired())
            <div class="text-center mb-3">
                <i class="fas fa-calendar-times fa-lg text-danger mb-2"></i>
                <p class="text-danger fw-semibold mb-1 small">Contract Expired</p>
                <p class="text-muted small">Expired on {{ $customer->contract_end_date->format('M d, Y') }}</p>
                <p class="text-danger small fw-semibold">{{ $customer->getDaysSinceExpiration() }} days ago</p>
            </div>
            @elseif($customer->isContractExpiring())
            <div class="text-center mb-3">
                <i class="fas fa-clock fa-lg text-warning mb-2"></i>
                <p class="text-warning fw-semibold mb-1 small">Contract Expiring Soon</p>
                <p class="text-muted small">Expires on {{ $customer->contract_end_date->format('M d, Y') }}</p>
                <p class="text-warning small fw-semibold">{{ $customer->getDisplayDaysUntilExpiration() }} days remaining</p>
            </div>
            @endif

            <div class="d-grid gap-2">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#renewModal">
                    <i class="fas fa-sync-alt me-2"></i>Renew Contract
                </button>
                <form action="{{ route('customers.renew', $customer) }}" method="POST" class="d-grid">
                    @csrf
                    <input type="hidden" name="contract_start_date" value="{{ now()->format('Y-m-d') }}">
                    <input type="hidden" name="contract_end_date" value="{{ now()->addYears(5)->format('Y-m-d') }}">
                    <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                    <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                    <button type="submit" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-bolt me-2"></i>Quick Renew (5 Years)
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
            <!-- Quick Actions -->
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-2"></i>Edit Customer
                        </a>

                        @if($customer->status == 'active' && !$customer->hasContractExpired())
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                            <i class="fas fa-tools me-2"></i>Record Maintenance
                        </button>
                        @else
                        <button type="button" class="btn btn-primary btn-sm" disabled>
                            <i class="fas fa-tools me-2"></i>Record Maintenance
                        </button>
                        @endif

                        <a href="tel:{{ $customer->phone_number }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-phone me-2"></i>Call Customer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Summary -->
            @if($customer->status == 'active' && !$customer->hasContractExpired())
            <div class="card glass-morphism border-0 shadow-sm">
                <div class="card-header bg-transparent py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>Service Summary
                    </h6>
                </div>
                <div class="card-body p-4">
                    @php
                        $allScheduledDates = $customer->getAllScheduledMaintenanceDates();
                        $completedCount = $allScheduledDates->where('completed', true)->count();
                        $pendingCount = $allScheduledDates->where('completed', false)->count();
                    @endphp
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-muted small">Service Type</span>
                            <span class="fw-semibold small">{{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-muted small">Maintenance Frequency</span>
                            <span class="fw-semibold small">
                                @if($customer->service_type === 'host_system')
                                    6 months
                                @else
                                    3 months
                                @endif
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-muted small">Total Maintenance</span>
                            <span class="badge bg-primary">{{ $allScheduledDates->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-muted small">Completed</span>
                            <span class="badge bg-success">{{ $completedCount }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-2">
                            <span class="text-muted small">Pending</span>
                            <span class="badge bg-warning">{{ $pendingCount }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    @if($allScheduledDates->count() > 0)
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Completion</small>
                            <small class="text-muted">{{ round(($completedCount / $allScheduledDates->count()) * 100) }}%</small>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: {{ ($completedCount / $allScheduledDates->count()) * 100 }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Maintenance Modal -->
@if($customer->status == 'active' && !$customer->hasContractExpired())
<div class="modal fade" id="maintenanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content glass-morphism border-0">
            <div class="modal-header bg-transparent border-0 py-3 px-4">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-tools me-2 text-primary"></i>Record Maintenance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.markMaintenance', $customer) }}" method="POST" id="maintenanceForm">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label for="maintenance_date" class="form-label fw-semibold small">Maintenance Date</label>
                        <input type="date" class="form-control modern-input" id="maintenance_date" name="maintenance_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold small">Notes</label>
                        <textarea class="form-control modern-input" id="notes" name="notes" rows="3" placeholder="Any notes about this maintenance..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-transparent border-0 py-3 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">Save Maintenance</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content glass-morphism border-0">
            <div class="modal-header bg-transparent border-0 py-3 px-4">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-sync-alt me-2 text-primary"></i>Renew Contract
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.renew', $customer) }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <!-- Contract Start Date -->
                    <div class="mb-3">
                        <label for="contract_start_date" class="form-label fw-semibold small">Contract Start Date</label>
                        <input type="date" class="form-control modern-input" id="contract_start_date" name="contract_start_date" value="{{ now()->format('Y-m-d') }}" required>
                    </div>

                    <!-- Contract End Date -->
                    <div class="mb-3">
                        <label for="contract_end_date" class="form-label fw-semibold small">Contract End Date</label>
                        <input type="date" class="form-control modern-input" id="contract_end_date" name="contract_end_date" value="{{ now()->addYears(5)->format('Y-m-d') }}" required>
                    </div>

                    <!-- Service Type -->
                    <div class="mb-3">
                        <label for="service_type" class="form-label fw-semibold small">Service Type</label>
                        <select class="form-control modern-select" id="service_type" name="service_type" required>
                            <option value="baiting_system_complete" {{ $customer->service_type == 'baiting_system_complete' ? 'selected' : '' }}>Baiting System Complete</option>
                            <option value="baiting_system_not_complete" {{ $customer->service_type == 'baiting_system_not_complete' ? 'selected' : '' }}>Baiting System Not Complete</option>
                            <option value="host_system" {{ $customer->service_type == 'host_system' ? 'selected' : '' }}>Host System</option>
                            <option value="drill_injection" {{ $customer->service_type == 'drill_injection' ? 'selected' : '' }}>Drill and Injection</option>
                        </select>
                    </div>

                    <!-- Service Price -->
                    <div class="mb-3">
                        <label for="service_price" class="form-label fw-semibold small">Service Price</label>
                        <input type="number" step="0.01" class="form-control modern-input" id="service_price" name="service_price" value="{{ $customer->service_price }}" required>
                    </div>
                </div>
                <div class="modal-footer bg-transparent border-0 py-3 px-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">Renew Contract</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* iPhone-style Slim Design */
.glass-morphism {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
}

.dark .glass-morphism {
    background: rgba(30, 30, 30, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Status Badges */
.status-badge {
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.7rem;
    display: inline-block;
}

.status-badge.active {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    color: white;
}

.status-badge.pending {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
}

.status-badge.expired {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.status-badge.expiring {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    color: white;
}

/* Service Badges */
.service-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.7rem;
    display: inline-block;
}

.service-badge.baiting-system {
    background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
    color: white;
}

.service-badge.host-system {
    background: linear-gradient(135deg, #20c997 0%, #0dcaf0 100%);
    color: white;
}

/* Modern Inputs */
.modern-input {
    border-radius: 10px;
    border: 1.5px solid #e9ecef;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.modern-input:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1);
}

.modern-select {
    border-radius: 10px;
    border: 1.5px solid #e9ecef;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.modern-select:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1);
}

/* Fixed Maintenance Schedule Styles */
.maintenance-scroll-container {
    max-height: 400px;
    overflow-y: auto;
    overflow-x: hidden;
    position: relative;
}

.maintenance-scroll-container {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 transparent;
}

.maintenance-scroll-container::-webkit-scrollbar {
    width: 8px;
}

.maintenance-scroll-container::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 4px;
    margin: 2px;
}

.maintenance-scroll-container::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 4px;
    border: 2px solid transparent;
    background-clip: padding-box;
}

.maintenance-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
    border: 2px solid transparent;
    background-clip: padding-box;
}

.maintenance-scroll-container::-webkit-scrollbar-thumb:active {
    background: #718096;
}

/* Fix hover conflicts */
.maintenance-scroll-container .maintenance-item {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f8f9fa !important;
    padding: 0.5rem 0.75rem !important;
    margin: 0;
}

.maintenance-scroll-container .maintenance-item:hover {
    background: rgba(25, 135, 84, 0.04) !important;
    border-left: 2px solid #198754 !important;
}

/* Remove transform on hover to prevent scrollbar jump */
.maintenance-scroll-container .maintenance-item:hover {
    transform: none !important;
}

/* Status indicators */
.maintenance-item.completed {
    border-left: 2px solid #198754;
}

.maintenance-item.overdue {
    border-left: 2px solid #dc3545;
}

.maintenance-item.upcoming {
    border-left: 2px solid #ffc107;
}

/* Smaller status badges */
.status-badge-sm {
    padding: 0.2rem 0.4rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.65rem;
    display: inline-block;
}

.status-badge-sm.active {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    color: white;
}

.status-badge-sm.pending {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
}

.status-badge-sm.expired {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.status-badge-sm.expiring {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    color: white;
}

/* Extra small button */
.btn-xs {
    padding: 0.2rem 0.5rem;
    font-size: 0.7rem;
    border-radius: 6px;
    border: 1px solid transparent;
}

/* Better row spacing */
.maintenance-item .row.g-2 {
    margin: 0 -4px;
}

.maintenance-item .col-1,
.maintenance-item .col-2,
.maintenance-item .col-3 {
    padding: 0 4px;
}

/* Info Items */
.info-item {
    padding: 0.5rem 0;
}

/* Dark Mode Support */
.dark .glass-morphism {
    background: rgba(30, 30, 30, 0.95);
}

.dark .modern-input,
.dark .modern-select {
    background: #2d3748;
    border-color: #4a5568;
    color: #e2e8f0;
}

.dark .modern-input:focus,
.dark .modern-select:focus {
    border-color: #48bb78;
    box-shadow: 0 0 0 0.2rem rgba(72, 187, 120, 0.1);
}

.dark .bg-light {
    background-color: #2d3748 !important;
}

.dark .text-dark {
    color: #e2e8f0 !important;
}

.dark .text-muted {
    color: #a0aec0 !important;
}

.dark .maintenance-scroll-container {
    scrollbar-color: #4a5568 transparent;
}

.dark .maintenance-scroll-container::-webkit-scrollbar-track {
    background: transparent;
}

.dark .maintenance-scroll-container::-webkit-scrollbar-thumb {
    background: #4a5568;
}

.dark .maintenance-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #718096;
}

.dark .maintenance-item {
    border-bottom-color: #2d3748 !important;
}

.dark .maintenance-item:hover {
    background: rgba(72, 187, 120, 0.05) !important;
}

/* Prevent content shift */
.maintenance-scroll-container .list-group-flush {
    margin: 0;
    padding: 0;
}

/* Smooth scrolling */
.maintenance-scroll-container {
    scroll-behavior: smooth;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .card-body {
        padding: 1rem !important;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}

/* Smooth Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: slideIn 0.3s ease forwards;
}

/* Stagger animation */
.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.15s; }
.card:nth-child(3) { animation-delay: 0.2s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus on notes field when maintenance modal opens
    const maintenanceModal = document.getElementById('maintenanceModal');
    if (maintenanceModal) {
        maintenanceModal.addEventListener('shown.bs.modal', function () {
            const notesField = document.getElementById('notes');
            if (notesField) notesField.focus();
        });
    }

    // Auto-focus on service price when renew modal opens
    const renewModal = document.getElementById('renewModal');
    if (renewModal) {
        renewModal.addEventListener('shown.bs.modal', function () {
            const servicePriceField = document.getElementById('service_price');
            if (servicePriceField) servicePriceField.focus();
        });
    }

    // Handle "Mark as Done" button clicks
    const markDoneButtons = document.querySelectorAll('.mark-done-btn');
    markDoneButtons.forEach(button => {
        button.addEventListener('click', function() {
            const maintenanceDate = this.getAttribute('data-date');
            document.getElementById('maintenance_date').value = maintenanceDate;

            const maintenanceModal = new bootstrap.Modal(document.getElementById('maintenanceModal'));
            maintenanceModal.show();
        });
    });

    // Handle form submission for maintenance
    const maintenanceForm = document.getElementById('maintenanceForm');
    if (maintenanceForm) {
        maintenanceForm.addEventListener('submit', function(e) {
            console.log('Submitting maintenance form with date:', document.getElementById('maintenance_date').value);
        });
    }
});
</script>
@endsection
