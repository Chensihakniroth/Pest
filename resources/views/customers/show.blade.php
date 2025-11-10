@php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <h2 class="h3 mb-1 text-dark fw-bold">Customer Details</h2>
            <p class="text-muted mb-0">Complete customer information and service history</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Customer
            </a>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <!-- Customer Profile Card -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient-primary text-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-semibold">
                            <i class="fas fa-user-circle me-2"></i>Customer Profile - {{ $customer->name }}
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            @if($customer->hasContractExpired())
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i class="fas fa-ban me-1"></i>EXPIRED
                                </span>
                            @else
                                <span class="badge bg-{{ $customer->status == 'active' ? 'success' : 'secondary' }} fs-6 px-3 py-2">
                                    {{ strtoupper($customer->status) }}
                                </span>
                            @endif
                            <span class="badge bg-info fs-6 px-3 py-2">
                                {{ $customer->customer_id }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark border-bottom pb-2 mb-3">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Basic Information
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Customer ID</label>
                                    <div class="fs-5 fw-bold text-dark">{{ $customer->customer_id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Full Name</label>
                                    <div class="fs-5 fw-bold text-dark">{{ $customer->name }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Phone Number</label>
                                    <div class="fs-5 fw-bold text-dark">
                                        <i class="fas fa-phone text-primary me-2"></i>{{ $customer->phone_number }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address & Location -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark border-bottom pb-2 mb-3">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Location
                                </h6>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Address</label>
                                    <div class="fs-6 text-dark">
                                        <i class="fas fa-home text-primary me-2"></i>{{ $customer->address }}
                                    </div>
                                </div>
                                @if($customer->google_map_link)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Map Location</label>
                                    <div>
                                        <a href="{{ $customer->google_map_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-2"></i>View on Google Maps
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Service Information -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-3">
                                <i class="fas fa-cogs me-2 text-primary"></i>Service Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Service Name</label>
                                    <div class="fs-6 fw-bold text-dark">{{ $customer->service_name }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Service Type</label>
                                    <div class="fs-6 fw-bold text-dark">
                                        <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Service Price</label>
                                    <div class="fs-6 fw-bold text-success">${{ number_format($customer->service_price, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contract Information -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-3">
                                <i class="fas fa-file-contract me-2 text-primary"></i>Contract Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Contract Start</label>
                                    <div class="fs-6 fw-bold text-dark">
                                        <i class="fas fa-calendar-plus text-primary me-2"></i>{{ $customer->contract_start_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Contract End</label>
                                    <div class="fs-6 fw-bold {{ $customer->isContractExpiring() ? 'text-danger' : 'text-dark' }}">
                                        <i class="fas fa-calendar-minus text-primary me-2"></i>{{ $customer->contract_end_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-muted mb-1 small text-uppercase">Contract Status</label>
                                    <div class="fs-6 fw-bold">
                                        @if($customer->hasContractExpired())
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Expired
                                            </span>
                                            <div class="text-danger small mt-1 fw-semibold">{{ $customer->getDaysSinceExpiration() }} days ago</div>
                                        @elseif($customer->isContractExpiring())
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                <i class="fas fa-clock me-1"></i>Expiring
                                            </span>
                                            <div class="text-warning small mt-1 fw-semibold">{{ $customer->getDisplayDaysUntilExpiration() }} days left</div>
                                        @else
                                            @if($customer->status == 'active')
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                                <div class="text-success small mt-1 fw-semibold">{{ $customer->getDisplayDaysUntilExpiration() }} days left</div>
                                            @else
                                                <span class="badge bg-secondary px-3 py-2">
                                                    <i class="fas fa-pause me-1"></i>Pending
                                                </span>
                                                <div class="text-muted small mt-1">Contract on hold</div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments -->
                    @if($customer->comments)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-3">
                                <i class="fas fa-comments me-2 text-primary"></i>Additional Notes
                            </h6>
                            <div class="bg-light rounded p-3 border">
                                <p class="mb-0 text-dark">{{ $customer->comments }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance Schedule - Only show if customer is active -->
            @if($customer->status == 'active')
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient-info text-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-semibold">
                            <i class="fas fa-calendar-alt me-2"></i>Maintenance Schedule
                        </h5>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                            <i class="fas fa-plus me-1"></i>Record Maintenance
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $allScheduledDates = $customer->getAllScheduledMaintenanceDates();
                    @endphp

                    @if($allScheduledDates->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">#</th>
                                        <th class="border-0">Scheduled Date</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Days</th>
                                        <th class="border-0 text-end pe-4">Actions</th>
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
                                        <tr class="{{ $isCompleted ? 'table-success' : ($isOverdue ? 'table-danger' : ($isUpcoming ? 'table-warning' : '')) }}">
                                            <td class="fw-semibold ps-4">{{ $schedule['maintenance_number'] }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    {{ $schedule['date']->format('M d, Y') }}
                                                    @if($isCompleted)
                                                        <i class="fas fa-check-circle text-success ms-2"></i>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($isCompleted)
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($isOverdue)
                                                    <span class="badge bg-danger">Overdue</span>
                                                @elseif($isUpcoming)
                                                    <span class="badge bg-warning text-dark">Upcoming</span>
                                                @else
                                                    <span class="badge bg-secondary">Scheduled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($isCompleted)
                                                    <span class="text-muted">Completed</span>
                                                @elseif($isOverdue)
                                                    <span class="text-danger fw-semibold">Overdue by {{ abs($daysDiff) }} days</span>
                                                @elseif($isUpcoming)
                                                    <span class="text-info fw-semibold">In {{ $daysDiff }} days</span>
                                                @else
                                                    <span class="text-muted">In {{ $daysDiff }} days</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                @if(!$isCompleted)
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="markMaintenanceAsDone('{{ $schedule['date']->format('Y-m-d') }}')">
                                                        <i class="fas fa-check me-1"></i>Mark Done
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
                            <i class="fas fa-calendar-times fa-2x mb-3"></i>
                            <p class="mb-0 fw-semibold">No maintenance schedule available</p>
                            <small>Maintenance dates will be generated based on service type</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-dark text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-history me-2"></i>Maintenance History
                    </h5>
                </div>
                <div class="card-body">
                    @if($maintenanceHistory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4">Date</th>
                                    <th class="border-0">Service Type</th>
                                    <th class="border-0">Performed By</th>
                                    <th class="border-0">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maintenanceHistory as $history)
                                <tr>
                                    <td class="fw-semibold ps-4">{{ $history->maintenance_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $history->service_type)) }}</span>
                                    </td>
                                    <td>{{ $history->performed_by ?? 'System' }}</td>
                                    <td class="text-muted">{{ $history->notes ?: 'No notes' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-clipboard-list fa-2x mb-3"></i>
                        <p class="mb-0 fw-semibold">No maintenance history recorded</p>
                        <small>Maintenance records will appear here once added</small>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Inactive Customer Message -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient-secondary text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-pause me-2"></i>Account On Hold
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <i class="fas fa-pause-circle fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted fw-semibold mb-2">Customer Account is Pending</h5>
                    <p class="text-muted mb-4">Maintenance features and contract management are available when the account status is set to Active.</p>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Customer to Activate
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Actions & Alerts -->
        <div class="col-lg-4">
            <!-- Contract Alerts -->
            @if($customer->status == 'active' && ($customer->hasContractExpired() || $customer->isContractExpiring()))
            <div class="card border-danger shadow-lg mb-4">
                <div class="card-header bg-gradient-danger text-white py-3 border-0">
                    <h6 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Contract Alert
                    </h6>
                </div>
                <div class="card-body">
                    @if($customer->hasContractExpired())
                    <div class="text-center mb-3">
                        <i class="fas fa-calendar-times fa-2x text-danger mb-2"></i>
                        <p class="text-danger fw-semibold mb-1">Contract Expired</p>
                        <p class="text-muted small">Expired on {{ $customer->contract_end_date->format('M d, Y') }}</p>
                    </div>
                    @else
                    <div class="text-center mb-3">
                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                        <p class="text-warning fw-semibold mb-1">Contract Expiring Soon</p>
                        <p class="text-muted small">{{ $customer->getDisplayDaysUntilExpiration() }} days remaining</p>
                    </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#renewModal">
                            <i class="fas fa-sync-alt me-2"></i>Renew Contract
                        </button>
                        <form action="{{ route('customers.renew', $customer) }}" method="POST" class="d-grid">
                            @csrf
                            <input type="hidden" name="contract_end_date" value="{{ now()->addYear()->format('Y-m-d') }}">
                            <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                            <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                            <button type="submit" class="btn btn-outline-success">
                                <i class="fas fa-bolt me-2"></i>Quick Renew (1 Year)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient-success text-white py-3 border-0">
                    <h6 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Customer
                        </a>

                        @if($customer->status == 'active')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                            <i class="fas fa-tools me-2"></i>Record Maintenance
                        </button>
                        @else
                        <button type="button" class="btn btn-primary" disabled>
                            <i class="fas fa-tools me-2"></i>Record Maintenance
                        </button>
                        @endif

                        <a href="tel:{{ $customer->phone_number }}" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Call Customer
                        </a>
                        @if($customer->google_map_link)
                        <a href="{{ $customer->google_map_link }}" target="_blank" class="btn btn-outline-info">
                            <i class="fas fa-map-marked-alt me-2"></i>View on Map
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Service Summary -->
            @if($customer->status == 'active')
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-info text-white py-3 border-0">
                    <h6 class="card-title mb-0 fw-semibold">
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
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                            <span class="text-muted">Service Type</span>
                            <span class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                            <span class="text-muted">Maintenance Frequency</span>
                            <span class="fw-semibold">
                                @if($customer->service_type === 'host_system')
                                    6 months
                                @else
                                    3 months
                                @endif
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                            <span class="text-muted">Total Maintenance</span>
                            <span class="badge bg-primary">{{ $allScheduledDates->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                            <span class="text-muted">Completed</span>
                            <span class="badge bg-success">{{ $completedCount }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                            <span class="text-muted">Pending</span>
                            <span class="badge bg-warning">{{ $pendingCount }}</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    @if($allScheduledDates->count() > 0)
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Completion Progress</small>
                            <small class="text-muted">{{ round(($completedCount / $allScheduledDates->count()) * 100) }}%</small>
                        </div>
                        <div class="progress" style="height: 6px;">
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
@if($customer->status == 'active')
<div class="modal fade" id="maintenanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
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

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-sync-alt me-2"></i>Renew Contract
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.renew', $customer) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contract_end_date" class="form-label fw-semibold">New Contract End Date</label>
                        <input type="date" class="form-control" id="contract_end_date" name="contract_end_date" value="{{ now()->addYear()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="service_type" class="form-label fw-semibold">Service Type</label>
                        <select class="form-control" id="service_type" name="service_type" required>
                            <option value="baiting_system_complete" {{ $customer->service_type == 'baiting_system_complete' ? 'selected' : '' }}>Baiting System Complete</option>
                            <option value="baiting_system_not_complete" {{ $customer->service_type == 'baiting_system_not_complete' ? 'selected' : '' }}>Baiting System Not Complete</option>
                            <option value="host_system" {{ $customer->service_type == 'host_system' ? 'selected' : '' }}>Host System</option>
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
@endif

<style>
.card {
    border-radius: 12px;
}

/* Gradient backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
}

.bg-gradient-dark {
    background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%) !important;
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #545b62 100%) !important;
}

.shadow-lg {
    box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    color: #495057;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5em 0.75em;
}

.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-1px);
}

.list-group-item {
    border: none;
    padding: 0.75rem 0;
}

.border-bottom {
    border-color: #dee2e6 !important;
}

.modal-content {
    border-radius: 12px;
    border: none;
}

.modal-header {
    border-radius: 12px 12px 0 0;
}

.table-success {
    background-color: rgba(25, 135, 84, 0.05);
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.05);
}

.table-danger {
    background-color: rgba(220, 53, 69, 0.05);
}

/* Progress bar styling */
.progress {
    border-radius: 3px;
    background-color: #e9ecef;
}

.progress-bar {
    border-radius: 3px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .btn-group {
        width: 100%;
    }
}
</style>

<script>
function markMaintenanceAsDone(date) {
    // Set the date in the maintenance form
    document.getElementById('maintenance_date').value = date;

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('maintenanceModal'));
    modal.show();
}

// Auto-focus on notes field when maintenance modal opens
document.getElementById('maintenanceModal').addEventListener('shown.bs.modal', function () {
    document.getElementById('notes').focus();
});

// Auto-focus on service price when renew modal opens
document.getElementById('renewModal').addEventListener('shown.bs.modal', function () {
    document.getElementById('service_price').focus();
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Only trigger shortcuts if no input, textarea, or select is focused
    const focusedElement = document.activeElement;
    const isInputFocused = focusedElement.tagName === 'INPUT' ||
                          focusedElement.tagName === 'TEXTAREA' ||
                          focusedElement.tagName === 'SELECT';

    if (isInputFocused) {
        return; // Don't trigger shortcuts when typing in forms
    }

    // 'e' for edit (with Ctrl/Cmd modifier)
    if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        window.location.href = "{{ route('customers.edit', $customer) }}";
    }

    // 'm' for maintenance (with Ctrl/Cmd modifier)
    if ((e.ctrlKey || e.metaKey) && e.key === 'm') {
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('maintenanceModal'));
        modal.show();
    }

    // Escape to go back (only when no modal is open)
    if (e.key === 'Escape' && !document.querySelector('.modal.show')) {
        window.location.href = "{{ route('customers.index') }}";
    }
});

// Print customer details
function printCustomerDetails() {
    window.print();
}

// Auto-refresh page every 2 minutes to update maintenance status
setTimeout(function() {
    window.location.reload();
}, 120000);
</script>
@endsection
