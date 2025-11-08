@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Statistics -->
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalCustomers }}</h4>
                        <p>Total Customers</p>
                    </div>
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $activeCustomers }}</h4>
                        <p>Active Customers</p>
                    </div>
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $expiringContracts }}</h4>
                        <p>Expiring Contracts</p>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $maintenanceAlerts->count() }}</h4>
                        <p>Maintenance Due</p>
                    </div>
                    <i class="fas fa-tools fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alerts Section -->
<div class="row">
    <!-- Maintenance Alerts -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tools"></i> Maintenance Alerts
                    <span class="badge bg-dark ms-2">{{ $maintenanceAlerts->count() }}</span>
                </h5>
                <div class="filter-section">
                    <select class="form-select form-select-sm" id="maintenanceFilter">
                        <option value="all">All Alerts</option>
                        <option value="baiting_system_complete">Baiting Complete</option>
                        <option value="baiting_system_not_complete">Baiting Not Complete</option>
                        <option value="host_system">Host System</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="alert-container" style="max-height: 400px; overflow-y: auto;">
                    @if($maintenanceAlerts->count() > 0)
                        @foreach($maintenanceAlerts as $customer)
                        <div class="alert-item maintenance-alert" data-service-type="{{ $customer->service_type }}">
                            <div class="alert alert-warning alert-compact d-flex justify-content-between align-items-center m-2 p-2">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong class="customer-name">{{ $customer->name }}</strong>
                                            <small class="text-muted d-block">ID: {{ $customer->customer_id }}</small>
                                        </div>
                                        <span class="badge bg-{{ $customer->service_type === 'host_system' ? 'info' : 'primary' }} ms-2">
                                            {{ $customer->service_type === 'host_system' ? 'Host' : 'Baiting' }}
                                        </span>
                                    </div>
                                    @if($customer->getNextMaintenanceDate())
                                        <small class="text-dark d-block mt-1">
                                            <i class="fas fa-calendar me-1"></i>
                                            Next: {{ $customer->getNextMaintenanceDate()->format('M d, Y') }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            @php
                                                $today = \Carbon\Carbon::today();
                                                $nextMaintenance = \Carbon\Carbon::parse($customer->getNextMaintenanceDate())->startOfDay();
                                                $daysUntilMaintenance = $today->diffInDays($nextMaintenance, false);
                                            @endphp
                                            @if($daysUntilMaintenance < 0)
                                                Overdue by {{ abs($daysUntilMaintenance) }} days
                                            @else
                                                Due in {{ $daysUntilMaintenance }} days
                                            @endif
                                        </small>
                                    @else
                                        <small class="text-danger d-block mt-1">
                                            <i class="fas fa-ban me-1"></i>
                                            Contract Expired - No Maintenance Required
                                        </small>
                                    @endif
                                </div>
                                <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center p-4 text-muted">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <p class="mb-0">No maintenance alerts</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contract Alerts -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-times"></i> Contract Expiration Alerts
                    <span class="badge bg-light text-dark ms-2">{{ $contractAlerts->count() }}</span>
                </h5>
                <div class="filter-section">
                    <select class="form-select form-select-sm" id="contractFilter">
                        <option value="all">All Contracts</option>
                        <option value="30">Within 30 days</option>
                        <option value="15">Within 15 days</option>
                        <option value="7">Within 7 days</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="alert-container" style="max-height: 400px; overflow-y: auto;">
                    @if($contractAlerts->count() > 0)
                        @foreach($contractAlerts as $customer)
                        @php
                            $daysLeft = $customer->getDisplayDaysUntilExpiration();
                            $urgencyClass = $daysLeft <= 7 ? 'high-urgency' : ($daysLeft <= 30 ? 'medium-urgency' : 'low-urgency');
                        @endphp
                        <div class="alert-item contract-alert" data-days-left="{{ $daysLeft }}">
                            <div class="alert alert-danger alert-compact d-flex justify-content-between align-items-center m-2 p-2 {{ $urgencyClass }}">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong class="customer-name">{{ $customer->name }}</strong>
                                            <small class="text-muted d-block">ID: {{ $customer->customer_id }}</small>
                                        </div>
                                        <span class="badge bg-{{ $daysLeft <= 7 ? 'dark' : 'secondary' }} ms-2">
                                            {{ $daysLeft }} days
                                        </span>
                                    </div>
                                    <small class="text-dark d-block mt-1">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Expires: {{ $customer->contract_end_date->format('M d, Y') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}
                                    </small>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#renewModal{{ $customer->id }}">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center p-4 text-muted">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <p class="mb-0">No contract alerts</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Expired Contracts Section -->
@if(isset($expiredContracts) && $expiredContracts->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="card border-danger mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-ban"></i> Expired Contracts
                    <span class="badge bg-light text-dark ms-2">{{ $expiredContracts->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Service Type</th>
                                <th>Contract End Date</th>
                                <th>Days Expired</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiredContracts as $customer)
                            @php
                                $daysExpired = $customer->getDaysSinceExpiration();
                            @endphp
                            <tr class="table-danger">
                                <td><strong>{{ $customer->customer_id }}</strong></td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</td>
                                <td>{{ $customer->contract_end_date->format('M d, Y') }}</td>
                                <td><span class="badge bg-dark">{{ $daysExpired }} days</span></td>
                                <td>
                                    <span class="badge bg-danger">EXPIRED</span>
                                </td>
                                <td>
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Recent Maintenance -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Maintenance Activities</h5>
                <a href="{{ route('customers.index') }}" class="btn btn-sm btn-success">View All Customers</a>
            </div>
            <div class="card-body">
                @if($recentMaintenance->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Service Type</th>
                                <th>Performed By</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentMaintenance as $maintenance)
                            <tr>
                                <td>{{ $maintenance->maintenance_date->format('M d, Y') }}</td>
                                <td>
                                    {{ $maintenance->customer->name }}
                                    @if($maintenance->customer->hasContractExpired())
                                        <span class="badge bg-danger ms-1">Expired</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst(str_replace('_', ' ', $maintenance->service_type)) }}
                                    </span>
                                </td>
                                <td>{{ $maintenance->performed_by }}</td>
                                <td>{{ Str::limit($maintenance->notes, 50) ?: 'No notes' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center">No maintenance history recorded yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .alert-compact {
        margin-bottom: 0.5rem !important;
        padding: 0.75rem !important;
        border-radius: 8px !important;
    }

    .alert-container {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }

    .alert-container::-webkit-scrollbar {
        width: 6px;
    }

    .alert-container::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 3px;
    }

    .alert-container::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }

    .alert-container::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }

    .alert-item {
        border-bottom: 1px solid #e2e8f0;
    }

    .alert-item:last-child {
        border-bottom: none;
    }

    .high-urgency {
        border-left: 4px solid #dc2626 !important;
    }

    .medium-urgency {
        border-left: 4px solid #ea580c !important;
    }

    .low-urgency {
        border-left: 4px solid #d97706 !important;
    }

    .filter-section {
        min-width: 150px;
    }

    .customer-name {
        font-size: 0.9rem;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Maintenance Alerts Filter
    const maintenanceFilter = document.getElementById('maintenanceFilter');
    if (maintenanceFilter) {
        maintenanceFilter.addEventListener('change', function() {
            const filterValue = this.value;
            const alerts = document.querySelectorAll('.maintenance-alert');

            alerts.forEach(alert => {
                if (filterValue === 'all' || alert.dataset.serviceType === filterValue) {
                    alert.style.display = 'block';
                } else {
                    alert.style.display = 'none';
                }
            });
        });
    }

    // Contract Alerts Filter
    const contractFilter = document.getElementById('contractFilter');
    if (contractFilter) {
        contractFilter.addEventListener('change', function() {
            const filterValue = this.value;
            const alerts = document.querySelectorAll('.contract-alert');

            alerts.forEach(alert => {
                const daysLeft = parseInt(alert.dataset.daysLeft);

                if (filterValue === 'all') {
                    alert.style.display = 'block';
                } else if (filterValue === '30' && daysLeft <= 30) {
                    alert.style.display = 'block';
                } else if (filterValue === '15' && daysLeft <= 15) {
                    alert.style.display = 'block';
                } else if (filterValue === '7' && daysLeft <= 7) {
                    alert.style.display = 'block';
                } else {
                    alert.style.display = 'none';
                }
            });
        });
    }

    // Auto-scroll to first urgent alert
    const urgentAlerts = document.querySelectorAll('.high-urgency, .medium-urgency');
    if (urgentAlerts.length > 0) {
        urgentAlerts[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
});
</script>

@endsection
