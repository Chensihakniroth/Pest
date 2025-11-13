@extends('layouts.app')

@section('content')
@php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
@endphp

<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 dark:text-gray-100 fw-bold">Customer Details</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-0 small">Complete customer information and service history</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Back to List
        </a>
    </div>

    <div class="row g-4">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <!-- Customer Profile Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-user-circle me-2"></i>Customer Profile
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            @if($customer->hasContractExpired())
                                <span class="badge bg-danger">EXPIRED</span>
                            @else
                                <span class="badge bg-{{ $customer->status == 'active' ? 'success' : 'warning' }}">
                                    {{ strtoupper($customer->status) }}
                                </span>
                            @endif
                            <span class="badge bg-primary">{{ $customer->customer_id }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                    <i class="fas fa-info-circle me-2 text-success"></i>Basic Information
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Customer ID</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">{{ $customer->customer_id }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Full Name</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">{{ $customer->name }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Phone Number</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">
                                        <i class="fas fa-phone text-success me-2"></i>{{ $customer->phone_number }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address & Location -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                    <i class="fas fa-map-marker-alt me-2 text-success"></i>Location
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Address</label>
                                    <div class="text-gray-800 dark:text-gray-100">
                                        <i class="fas fa-home text-success me-2"></i>{{ $customer->address }}
                                    </div>
                                </div>

                                @if($customer->google_map_link)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Map Location</label>
                                    <div>
                                        <a href="{{ $customer->google_map_link }}" target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-2"></i>
                                            View on Maps
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
                            <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                <i class="fas fa-cogs me-2 text-success"></i>Service Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Service Name</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">{{ $customer->service_name }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Service Type</label>
                                    <div>
                                        <span class="badge bg-{{ $customer->service_type === 'host_system' ? 'info' : 'primary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Service Price</label>
                                    <div class="fw-bold text-success">${{ number_format($customer->service_price, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contract Information -->
                    <div class="row mt-2">
                        <div class="col-12">
                            <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                <i class="fas fa-file-contract me-2 text-success"></i>Contract Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Contract Start</label>
                                    <div class="fw-bold text-gray-800 dark:text-gray-100">
                                        <i class="fas fa-calendar-plus text-success me-2"></i>{{ $customer->contract_start_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Contract End</label>
                                    @php
                                        $daysUntilExpiration = $customer->getDisplayDaysUntilExpiration();
                                        $isExpiringSoon = $customer->isContractExpiring();
                                    @endphp
                                    <div class="fw-bold {{ $isExpiringSoon ? 'text-warning' : ($customer->hasContractExpired() ? 'text-danger' : 'text-gray-800 dark:text-gray-100') }}">
                                        <i class="fas fa-calendar-minus text-success me-2"></i>{{ $customer->contract_end_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-gray-600 dark:text-gray-400 mb-1 small">Contract Status</label>
                                    <div>
                                        @php
                                            $customer->updateContractStatus();
                                        @endphp

                                        @if($customer->hasContractExpired() || $customer->status === 'expired')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Expired
                                            </span>
                                            <div class="text-danger small mt-1 fw-semibold">{{ $customer->getDaysSinceExpiration() }} days ago</div>
                                        @elseif($customer->isContractExpiring())
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Expiring Soon
                                            </span>
                                        @else
                                            @if($customer->status == 'active')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                                <div class="text-success small mt-1 fw-semibold">{{ $customer->getDisplayDaysUntilExpiration() }} days left</div>
                                            @else
                                                <span class="badge bg-secondary">
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
                            <h6 class="fw-semibold text-gray-800 dark:text-gray-100 mb-3 small text-uppercase">
                                <i class="fas fa-comments me-2 text-success"></i>Additional Notes
                            </h6>
                            <div class="bg-light dark:bg-dark rounded p-3 border">
                                <p class="mb-0 text-gray-800 dark:text-gray-100 small">{{ $customer->comments }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance Schedule -->
            @if($customer->status == 'active' && !$customer->hasContractExpired())
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-calendar-alt me-2"></i>Maintenance Schedule
                        </h5>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                            <i class="fas fa-plus me-2"></i>
                            Record
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @php
                        $allScheduledDates = $customer->getAllScheduledMaintenanceDates();
                    @endphp

                    @if($allScheduledDates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="small fw-semibold">#</th>
                                        <th class="small fw-semibold">Date</th>
                                        <th class="small fw-semibold">Status</th>
                                        <th class="small fw-semibold">Days</th>
                                        <th class="small fw-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allScheduledDates as $schedule)
                                        @php
                                            $isOverdue = $schedule['type'] === 'overdue';
                                            $isUpcoming = $schedule['type'] === 'upcoming';
                                            $isScheduled = $schedule['type'] === 'scheduled';
                                            $daysDiff = $schedule['days'];
                                            $isCompleted = $schedule['completed'];
                                        @endphp
                                        <tr>
                                            <td class="small">#{{ $schedule['maintenance_number'] }}</td>
                                            <td class="small">
                                                {{ $schedule['date']->format('M d, Y') }}
                                                @if($isCompleted)
                                                    <i class="fas fa-check-circle text-success ms-1"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if($isCompleted)
                                                    <span class="badge bg-success">Done</span>
                                                @elseif($isOverdue)
                                                    <span class="badge bg-danger">Overdue</span>
                                                @elseif($isUpcoming)
                                                    <span class="badge bg-warning">Upcoming</span>
                                                @else
                                                    <span class="badge bg-secondary">Scheduled</span>
                                                @endif
                                            </td>
                                            <td class="small">
                                                @if($isCompleted)
                                                    <span class="text-muted">Completed</span>
                                                @elseif($isOverdue)
                                                    <span class="text-danger fw-semibold">Overdue {{ abs($daysDiff) }}d</span>
                                                @elseif($isUpcoming)
                                                    <span class="text-warning fw-semibold">In {{ $daysDiff }}d</span>
                                                @else
                                                    <span class="text-muted">In {{ $daysDiff }}d</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!$isCompleted)
                                                    <button type="button" class="btn btn-success btn-sm" data-date="{{ $schedule['date']->format('Y-m-d') }}" onclick="setMaintenanceDate(this)">
                                                        <i class="fas fa-check me-1"></i>
                                                        Mark Done
                                                    </button>
                                                @else
                                                    <span class="text-muted small">Completed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-lg mb-3 opacity-50"></i>
                            <p class="mb-0 fw-semibold small">No maintenance schedule</p>
                            <small>Maintenance dates will be generated based on service type</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-history me-2"></i>Maintenance History
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($maintenanceHistory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="small fw-semibold">Date</th>
                                    <th class="small fw-semibold">Service Type</th>
                                    <th class="small fw-semibold">Performed By</th>
                                    <th class="small fw-semibold">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maintenanceHistory as $history)
                                <tr>
                                    <td class="small">{{ $history->maintenance_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $history->service_type === 'host_system' ? 'info' : 'primary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $history->service_type)) }}
                                        </span>
                                    </td>
                                    <td class="small">{{ $history->performed_by ?? 'System' }}</td>
                                    <td class="small">{{ $history->notes ?: 'No notes' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-clipboard-list fa-lg mb-3 opacity-50"></i>
                        <p class="mb-0 fw-semibold small">No maintenance history</p>
                        <small>Maintenance records will appear here once added</small>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Inactive Customer Message -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-pause me-2"></i>Account On Hold
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
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Edit
                        </a>
                        @if($customer->hasContractExpired())
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#renewModal">
                                <i class="fas fa-sync-alt me-2"></i>
                                Renew
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
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Contract Alert
                    </h6>
                </div>
                <div class="card-body">
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
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#renewModal">
                            <i class="fas fa-sync-alt me-2"></i>Renew Contract
                        </button>
                        <form action="{{ route('customers.renew', $customer) }}" method="POST" class="d-grid">
                            @csrf
                            <input type="hidden" name="contract_start_date" value="{{ now()->format('Y-m-d') }}">
                            <input type="hidden" name="contract_end_date" value="{{ now()->addYears(5)->format('Y-m-d') }}">
                            <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                            <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                            <button type="submit" class="btn btn-outline-success">
                                <i class="fas fa-bolt me-2"></i>Quick Renew (5 Years)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Customer
                        </a>

                        @if($customer->status == 'active' && !$customer->hasContractExpired())
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                            <i class="fas fa-tools me-2"></i>Record Maintenance
                        </button>
                        @else
                        <button type="button" class="btn btn-secondary" disabled>
                            <i class="fas fa-tools me-2"></i>Record Maintenance
                        </button>
                        @endif

                        <a href="tel:{{ $customer->phone_number }}" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Call Customer
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Summary -->
            @if($customer->status == 'active' && !$customer->hasContractExpired())
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-pie me-2"></i>Service Summary
                    </h6>
                </div>
                <div class="card-body">
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
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="fas fa-tools me-2"></i>Record Maintenance
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.markMaintenance', $customer) }}" method="POST" id="maintenanceForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="maintenance_date" class="form-label fw-semibold">Maintenance Date</label>
                        <input type="date" class="form-control" id="maintenance_date" name="maintenance_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any notes about this maintenance..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Maintenance</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="fas fa-sync-alt me-2"></i>Renew Contract
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.renew', $customer) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contract_start_date" class="form-label fw-semibold">Contract Start Date</label>
                        <input type="date" class="form-control" id="contract_start_date" name="contract_start_date" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="contract_end_date" class="form-label fw-semibold">Contract End Date</label>
                        <input type="date" class="form-control" id="contract_end_date" name="contract_end_date" value="{{ now()->addYears(5)->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="service_type" class="form-label fw-semibold">Service Type</label>
                        <select class="form-select" id="service_type" name="service_type" required>
                            <option value="baiting_system_complete" {{ $customer->service_type == 'baiting_system_complete' ? 'selected' : '' }}>Baiting System Complete</option>
                            <option value="baiting_system_not_complete" {{ $customer->service_type == 'baiting_system_not_complete' ? 'selected' : '' }}>Baiting System Not Complete</option>
                            <option value="host_system" {{ $customer->service_type == 'host_system' ? 'selected' : '' }}>Host System</option>
                            <option value="drill_injection" {{ $customer->service_type == 'drill_injection' ? 'selected' : '' }}>Drill and Injection</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="service_price" class="form-label fw-semibold">Service Price</label>
                        <input type="number" step="0.01" class="form-control" id="service_price" name="service_price" value="{{ $customer->service_price }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Renew Contract</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
});

// Set maintenance date from mark done button
function setMaintenanceDate(button) {
    const maintenanceDate = button.getAttribute('data-date');
    document.getElementById('maintenance_date').value = maintenanceDate;

    const maintenanceModal = new bootstrap.Modal(document.getElementById('maintenanceModal'));
    maintenanceModal.show();
}
</script>

<style>
/* Custom styles that work with your existing CSS */
.card {
    border-radius: 12px;
}

.card-header.bg-dark {
    background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%) !important;
}

.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

/* Dark mode support */
html.dark-mode .card {
    background-color: #1a1d2e;
    border: 1px solid #2d3748;
}

html.dark-mode .card-header.bg-dark {
    background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%) !important;
}

html.dark-mode .table {
    color: #e2e8f0;
}

html.dark-mode .table th {
    background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    border-color: #4a5568;
    color: #e2e8f0;
}

html.dark-mode .table td {
    background-color: #1a1d2e;
    border-color: #2d3748;
    color: #e2e8f0;
}

html.dark-mode .bg-light {
    background-color: #2d3748 !important;
}

html.dark-mode .text-muted {
    color: #a0aec0 !important;
}

html.dark-mode .modal-content {
    background-color: #1a1d2e;
    border: 1px solid #4a5568;
    color: #e2e8f0;
}

html.dark-mode .modal-header {
    border-bottom-color: #4a5568;
    background: linear-gradient(135deg, #1a1d2e 0%, #161827 100%);
}
</style>
@endsection
