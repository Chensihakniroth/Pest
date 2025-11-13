    @extends('layouts.app')

    @section('content')
    @php
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    @endphp

    <div class="dashboard-container">
        <!-- Modern Header matching your dashboard -->
        <div class="dashboard-header">
            <div class="header-content">
                <div class="header-text">
                    <h1 class="dashboard-title">Customer Details</h1>
                    <p class="dashboard-subtitle">View and manage customer information, contracts, and maintenance history</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('customers.index') }}" class="btn-back-dashboard">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to List</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column - Main Content -->
            <div class="col-lg-8">
                <!-- Customer Profile Card -->
                <div class="card shadow-lg border-0 customer-profile-card">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-user-circle me-2"></i>Customer Profile
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                @if($customer->hasContractExpired())
                                    <span class="badge bg-gradient-danger">EXPIRED</span>
                                @else
                                    <span class="badge bg-{{ $customer->status == 'active' ? 'success' : 'warning' }}">
                                        {{ strtoupper($customer->status) }}
                                    </span>
                                @endif
                                <span class="badge bg-gradient-info">{{ $customer->customer_id }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="section-title mb-3">
                                        <i class="fas fa-info-circle me-2"></i>Basic Information
                                    </h6>

                                    <div class="info-item mb-3">
                                        <label class="info-label">Customer ID</label>
                                        <div class="info-value">{{ $customer->customer_id }}</div>
                                    </div>

                                    <div class="info-item mb-3">
                                        <label class="info-label">Full Name</label>
                                        <div class="info-value">{{ $customer->name }}</div>
                                    </div>

                                    <div class="info-item mb-3">
                                        <label class="info-label">Phone Number</label>
                                        <div class="info-value with-icon">
                                            <i class="fas fa-phone me-2"></i>{{ $customer->phone_number }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address & Location -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="section-title mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Location
                                    </h6>

                                    <div class="info-item mb-3">
                                        <label class="info-label">Address</label>
                                        <div class="info-value with-icon">
                                            <i class="fas fa-home me-2"></i>{{ $customer->address }}
                                        </div>
                                    </div>

                                    @if($customer->google_map_link)
                                    <div class="info-item">
                                        <label class="info-label">Map Location</label>
                                        <div>
                                            <a href="{{ $customer->google_map_link }}" target="_blank" class="btn btn-primary btn-map">
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
                        <div class="service-section">
                            <h6 class="section-title mb-3">
                                <i class="fas fa-cogs me-2"></i>Service Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="info-label">Service Name</label>
                                    <div class="info-value">{{ $customer->service_name }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="info-label">Service Type</label>
                                    <div>
                                        <span class="service-badge {{ $customer->service_type === 'host_system' ? 'host-system' : 'baiting-system' }}">
                                            {{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="info-label">Service Price</label>
                                    <div class="info-value price">${{ number_format($customer->service_price, 2) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Contract Information -->
                        <div class="contract-section">
                            <h6 class="section-title mb-3">
                                <i class="fas fa-file-contract me-2"></i>Contract Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="info-label">Contract Start</label>
                                    <div class="info-value with-icon">
                                        <i class="fas fa-calendar-plus me-2"></i>{{ $customer->contract_start_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="info-label">Contract End</label>
                                    @php
                                        $daysUntilExpiration = $customer->getDisplayDaysUntilExpiration();
                                        $isExpiringSoon = $customer->isContractExpiring();
                                    @endphp
                                    <div class="info-value with-icon {{ $isExpiringSoon ? 'text-warning' : ($customer->hasContractExpired() ? 'text-danger' : '') }}">
                                        <i class="fas fa-calendar-minus me-2"></i>{{ $customer->contract_end_date->format('M d, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="info-label">Contract Status</label>
                                    <div class="contract-status">
                                        @php
                                            $customer->updateContractStatus();
                                        @endphp

                                        @if($customer->hasContractExpired())
                                            <span class="badge bg-gradient-danger">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Expired
                                            </span>
                                            <div class="status-detail text-danger">{{ $customer->getDaysSinceExpiration() }} days ago</div>
                                        @elseif($customer->isContractExpiring())
                                            <span class="badge bg-gradient-warning">
                                                <i class="fas fa-clock me-1"></i>Expiring Soon
                                            </span>
                                            <div class="status-detail text-warning">{{ $customer->getDisplayDaysUntilExpiration() }} days left</div>
                                        @else
                                            @if($customer->status == 'active')
                                                <span class="badge bg-gradient-success">
                                                    <i class="fas fa-check-circle me-1"></i>Active
                                                </span>
                                                <div class="status-detail text-success">{{ $customer->getDisplayDaysUntilExpiration() }} days left</div>
                                            @elseif($customer->status == 'pending')
                                                <span class="badge bg-gradient-secondary">
                                                    <i class="fas fa-pause me-1"></i>Pending
                                                </span>
                                                <div class="status-detail text-muted">Account On Hold</div>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-ban me-1"></i>Inactive
                                                </span>
                                                <div class="status-detail text-muted">Account Inactive</div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Contract Alert Banner -->
                            @if($customer->isContractExpiring() && !$customer->hasContractExpired() && $customer->status == 'active')
                            <div class="alert alert-warning alert-dismissible fade show contract-alert" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="alert-heading mb-1 fw-bold">Contract Expiring Soon!</h6>
                                        <p class="mb-0">
                                            This contract will expire in <strong>{{ $customer->getDisplayDaysUntilExpiration() }} days</strong>
                                            on <strong>{{ $customer->contract_end_date->format('M d, Y') }}</strong>.
                                        </p>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                        </div>

                        <!-- Comments -->
                        @if($customer->comments)
                        <div class="comments-section">
                            <h6 class="section-title mb-3">
                                <i class="fas fa-comments me-2"></i>Additional Notes
                            </h6>
                            <div class="comments-box">
                                <p class="mb-0">{{ $customer->comments }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Maintenance Schedule & History - Only show for ACTIVE customers with valid contracts -->
                @if($customer->status == 'active' && !$customer->hasContractExpired())
                    <!-- Maintenance Schedule -->
                    <div class="card shadow-lg border-0 maintenance-card">
                        <div class="card-header bg-gradient-primary text-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-calendar-alt me-2"></i>Maintenance Schedule
                                </h5>
                                <button type="button" class="btn btn-success btn-record" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                                    <i class="fas fa-plus me-2"></i>
                                    Record Maintenance
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $allScheduledDates = $customer->getAllScheduledMaintenanceDates();
                            @endphp

                            @if($allScheduledDates->count() > 0)
                                <div class="maintenance-table-container">
                                    <table class="table table-hover maintenance-table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="fw-semibold">#</th>
                                                <th class="fw-semibold">Date</th>
                                                <th class="fw-semibold">Status</th>
                                                <th class="fw-semibold">Days</th>
                                                <th class="fw-semibold">Action</th>
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
                                                <tr class="maintenance-row {{ $isCompleted ? 'completed' : ($isOverdue ? 'overdue' : ($isUpcoming ? 'upcoming' : '')) }}">
                                                    <td class="fw-semibold">#{{ $schedule['maintenance_number'] }}</td>
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
                                                            <span class="badge bg-gradient-success">Completed</span>
                                                        @elseif($isOverdue)
                                                            <span class="badge bg-gradient-danger">Overdue</span>
                                                        @elseif($isUpcoming)
                                                            <span class="badge bg-gradient-warning">Upcoming</span>
                                                        @else
                                                            <span class="badge bg-secondary">Scheduled</span>
                                                        @endif
                                                    </td>
                                                    <td class="fw-semibold {{ $isOverdue ? 'text-danger' : ($isUpcoming ? 'text-warning' : 'text-muted') }}">
                                                        @if($isCompleted)
                                                            <span class="text-muted">Completed</span>
                                                        @elseif($isOverdue)
                                                            Overdue {{ abs($daysDiff) }}d
                                                        @elseif($isUpcoming)
                                                            In {{ $daysDiff }}d
                                                        @else
                                                            In {{ $daysDiff }}d
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!$isCompleted)
                                                            <button type="button" class="btn btn-success btn-sm btn-mark-done"
                                                                    data-date="{{ $schedule['date']->format('Y-m-d') }}">
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
                                <div class="text-center py-5 empty-state">
                                    <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                                    <h6 class="text-muted fw-semibold">No maintenance schedule</h6>
                                    <p class="text-muted small">Maintenance dates will be generated based on service type</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Maintenance History -->
                    <div class="card shadow-lg border-0 history-card">
                        <div class="card-header bg-gradient-primary text-white py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-history me-2"></i>Maintenance History
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if($maintenanceHistory->count() > 0)
                            <div class="history-table-container">
                                <table class="table table-hover history-table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold">Date</th>
                                            <th class="fw-semibold">Service Type</th>
                                            <th class="fw-semibold">Performed By</th>
                                            <th class="fw-semibold">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($maintenanceHistory as $history)
                                        <tr class="history-row">
                                            <td class="fw-semibold">{{ $history->maintenance_date->format('M d, Y') }}</td>
                                            <td>
                                                <span class="service-badge small {{ $history->service_type === 'host_system' ? 'host-system' : 'baiting-system' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $history->service_type)) }}
                                                </span>
                                            </td>
                                            <td>{{ $history->performed_by ?? 'System' }}</td>
                                            <td class="text-muted">{{ $history->notes ?: 'No notes' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5 empty-state">
                                <i class="fas fa-clipboard-list fa-2x text-muted mb-3"></i>
                                <h6 class="text-muted fw-semibold">No maintenance history</h6>
                                <p class="text-muted small">Maintenance records will appear here once added</p>
                            </div>
                            @endif
                        </div>
                    </div>
                @else
                    <!-- Inactive Customer Message - Show for PENDING status OR EXPIRED contracts -->
                    <div class="card shadow-lg border-0 inactive-card">
                        <div class="card-header bg-gradient-primary text-white py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-pause me-2"></i>Account On Hold
                            </h5>
                        </div>
                        <div class="card-body text-center py-5">
                            <i class="fas fa-pause-circle fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted fw-semibold mb-2">
                                @if($customer->hasContractExpired())
                                    Contract Expired
                                @elseif($customer->status == 'pending')
                                    Customer Account is Pending
                                @else
                                    Account Inactive
                                @endif
                            </h6>
                            <p class="text-muted mb-4">
                                @if($customer->status == 'pending')
                                    <strong>Account Status: Pending</strong> - Maintenance features are disabled until the account is activated.
                                @elseif($customer->hasContractExpired())
                                    This contract has expired. Maintenance features are disabled until the contract is renewed.
                                @else
                                    Maintenance features and contract management are available when the account status is set to Active.
                                @endif
                            </p>
                            <div class="d-flex gap-3 justify-content-center">
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit Customer
                                </a>
                                @if($customer->hasContractExpired())
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#renewModal">
                                        <i class="fas fa-sync-alt me-2"></i>
                                        Renew Contract
                                    </button>
                                @elseif($customer->status == 'pending')
                                    <form action="{{ route('customers.update', $customer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="active">
                                        <input type="hidden" name="name" value="{{ $customer->name }}">
                                        <input type="hidden" name="phone_number" value="{{ $customer->phone_number }}">
                                        <input type="hidden" name="address" value="{{ $customer->address }}">
                                        <input type="hidden" name="service_name" value="{{ $customer->service_name }}">
                                        <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                                        <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                                        <input type="hidden" name="contract_start_date" value="{{ $customer->contract_start_date->format('Y-m-d') }}">
                                        <input type="hidden" name="contract_end_date" value="{{ $customer->contract_end_date->format('Y-m-d') }}">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-play me-2"></i>
                                            Activate Account
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Actions & Summary -->
            <div class="col-lg-4">
                <!-- Contract Alerts Card - Only show for ACTIVE customers -->
                @if($customer->status == 'active')
                <div class="card shadow-lg border-0 alert-card">
                    <div class="card-header bg-gradient-{{ $customer->hasContractExpired() ? 'danger' : ($customer->isContractExpiring() ? 'warning' : 'primary') }} text-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-exclamation-triangle me-2"></i>Contract Alert
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($customer->hasContractExpired())
                        <div class="alert-content text-center mb-4">
                            <i class="fas fa-calendar-times fa-2x text-danger mb-3"></i>
                            <h6 class="text-danger fw-bold mb-2">Contract Expired</h6>
                            <p class="text-muted mb-2">Expired on {{ $customer->contract_end_date->format('M d, Y') }}</p>
                            <p class="text-danger fw-bold">{{ $customer->getDaysSinceExpiration() }} days ago</p>
                        </div>
                        @elseif($customer->isContractExpiring())
                        <div class="alert-content text-center mb-4">
                            <i class="fas fa-clock fa-2x text-warning mb-3"></i>
                            <h6 class="text-warning fw-bold mb-2">Contract Expiring Soon</h6>
                            <p class="text-muted mb-2">Expires on {{ $customer->contract_end_date->format('M d, Y') }}</p>
                            <p class="text-warning fw-bold">{{ $customer->getDisplayDaysUntilExpiration() }} days remaining</p>
                        </div>
                        @else
                        <div class="alert-content text-center mb-4">
                            <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                            <h6 class="text-success fw-bold mb-2">Contract Active</h6>
                            <p class="text-muted mb-2">Valid until {{ $customer->contract_end_date->format('M d, Y') }}</p>
                            <p class="text-success fw-bold">{{ $customer->getDisplayDaysUntilExpiration() }} days remaining</p>
                        </div>
                        @endif

                        <div class="action-buttons">
                            <button type="button" class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#renewModal">
                                <i class="fas fa-sync-alt me-2"></i>Renew Contract
                            </button>
                            <form action="{{ route('customers.renew', $customer) }}" method="POST">
                                @csrf
                                <input type="hidden" name="contract_start_date" value="{{ now()->format('Y-m-d') }}">
                                <input type="hidden" name="contract_end_date" value="{{ now()->addYears(5)->format('Y-m-d') }}">
                                <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                                <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fas fa-bolt me-2"></i>Quick Renew (5 Years)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick Actions -->
                <div class="card shadow-lg border-0 actions-card">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning w-100 mb-2">
                                <i class="fas fa-edit me-2"></i>Edit Customer
                            </a>

                            @if($customer->status == 'active' && !$customer->hasContractExpired())
                            <button type="button" class="btn btn-info w-100 mb-2" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                                <i class="fas fa-tools me-2"></i>Record Maintenance
                            </button>
                            @else
                            <button type="button" class="btn btn-secondary w-100 mb-2" disabled>
                                <i class="fas fa-tools me-2"></i>Record Maintenance
                            </button>
                            @endif

                            <a href="tel:{{ $customer->phone_number }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-phone me-2"></i>Call Customer
                            </a>

                            <!-- Quick Status Toggle -->
                            @if($customer->status == 'active')
                            <form action="{{ route('customers.update', $customer) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="pending">
                                <input type="hidden" name="name" value="{{ $customer->name }}">
                                <input type="hidden" name="phone_number" value="{{ $customer->phone_number }}">
                                <input type="hidden" name="address" value="{{ $customer->address }}">
                                <input type="hidden" name="service_name" value="{{ $customer->service_name }}">
                                <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                                <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                                <input type="hidden" name="contract_start_date" value="{{ $customer->contract_start_date->format('Y-m-d') }}">
                                <input type="hidden" name="contract_end_date" value="{{ $customer->contract_end_date->format('Y-m-d') }}">
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-pause me-2"></i>Set to Pending
                                </button>
                            </form>
                            @elseif($customer->status == 'pending')
                            <form action="{{ route('customers.update', $customer) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="active">
                                <input type="hidden" name="name" value="{{ $customer->name }}">
                                <input type="hidden" name="phone_number" value="{{ $customer->phone_number }}">
                                <input type="hidden" name="address" value="{{ $customer->address }}">
                                <input type="hidden" name="service_name" value="{{ $customer->service_name }}">
                                <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                                <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                                <input type="hidden" name="contract_start_date" value="{{ $customer->contract_start_date->format('Y-m-d') }}">
                                <input type="hidden" name="contract_end_date" value="{{ $customer->contract_end_date->format('Y-m-d') }}">
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fas fa-play me-2"></i>Activate Account
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Service Summary - Only show for ACTIVE customers with valid contracts -->
                @if($customer->status == 'active' && !$customer->hasContractExpired())
                <div class="card shadow-lg border-0 summary-card">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-chart-pie me-2"></i>Service Summary
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $allScheduledDates = $customer->getAllScheduledMaintenanceDates();
                            $completedCount = $allScheduledDates->where('completed', true)->count();
                            $pendingCount = $allScheduledDates->where('completed', false)->count();
                        @endphp

                        <div class="summary-list">
                            <div class="summary-item">
                                <span class="summary-label">Service Type</span>
                                <span class="summary-value">{{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Maintenance Frequency</span>
                                <span class="summary-value">
                                    @if($customer->service_type === 'host_system')
                                        6 months
                                    @else
                                        3 months
                                    @endif
                                </span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total Maintenance</span>
                                <span class="badge bg-primary">{{ $allScheduledDates->count() }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Completed</span>
                                <span class="badge bg-success">{{ $completedCount }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Pending</span>
                                <span class="badge bg-warning">{{ $pendingCount }}</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        @if($allScheduledDates->count() > 0)
                        <div class="progress-section mt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Completion Progress</small>
                                <small class="text-muted fw-semibold">{{ round(($completedCount / $allScheduledDates->count()) * 100) }}%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
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

    <!-- Maintenance Modal - Only show for ACTIVE customers with valid contracts -->
    @if($customer->status == 'active' && !$customer->hasContractExpired())
    <div class="modal fade" id="maintenanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title fw-bold">
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
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title fw-bold">
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

        <style>
        /* Customer Show Specific Styles */
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Dashboard Header Styles */
        .dashboard-header {
            margin-bottom: 2rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 2rem;
        }

        .header-text {
            flex: 1;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gh-text);
            margin: 0 0 0.5rem 0;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dashboard-subtitle {
            color: var(--gh-text-light);
            margin: 0;
            font-size: 1rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-back-dashboard {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(25, 135, 84, 0.3);
        }

        .btn-back-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(25, 135, 84, 0.4);
            color: white;
        }

        /* Card Styles */
        .card {
            border-radius: 16px;
            border: none;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            border-radius: 16px 16px 0 0 !important;
            border: none;
        }

        /* Section Titles */
        .section-title {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 600;
            color: #2d3748;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }

        .section-title i {
            color: var(--primary-green);
            font-size: 0.8rem;
        }

        /* Info Items */
        .info-item {
            margin-bottom: 1rem;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
        }

        .info-value.with-icon {
            display: flex;
            align-items: center;
        }

        .info-value.price {
            color: var(--primary-green);
            font-weight: 700;
        }

        /* Service Badges */
        .service-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .service-badge.baiting-system {
            background: var(--gradient-primary);
            color: white;
        }

        .service-badge.host-system {
            background: var(--gradient-info);
            color: white;
        }

        .service-badge.small {
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
        }

        /* Contract Status */
        .contract-status {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .status-detail {
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Alert Styles */
        .contract-alert {
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-left: 4px solid #f59e0b;
        }

        /* Comments Box */
        .comments-box {
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* Table Styles */
        .maintenance-table-container,
        .history-table-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .maintenance-table,
        .history-table {
            margin: 0;
        }

        .maintenance-table th,
        .history-table th {
            background: #f8f9fa;
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 1rem;
        }

        .maintenance-table td,
        .history-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f8f9fa;
        }

        .maintenance-row:hover,
        .history-row:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .maintenance-row.completed {
            border-left: 4px solid #10b981;
        }

        .maintenance-row.overdue {
            border-left: 4px solid #ef4444;
        }

        .maintenance-row.upcoming {
            border-left: 4px solid #f59e0b;
        }

        /* Buttons */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-record {
            background: var(--gradient-success);
            border: none;
        }

        .btn-mark-done {
            background: var(--gradient-success);
            border: none;
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }

        .btn-map {
            background: var(--gradient-info);
            border: none;
        }

        /* Summary Styles */
        .summary-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .summary-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        .summary-value {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.875rem;
        }

        /* Progress Bar */
        .progress {
            border-radius: 4px;
            background: #e5e7eb;
        }

        .progress-bar {
            border-radius: 4px;
        }

        /* Empty States */
        .empty-state {
            padding: 2rem;
        }

        .empty-state i {
            opacity: 0.5;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        /* Dark Mode Support */
        html.dark-mode .card {
            background-color: #1a1d2e;
            border: 1px solid #2d3748;
        }

        html.dark-mode .card-header {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%) !important;
        }

        html.dark-mode .info-value {
            color: #e2e8f0;
        }

        html.dark-mode .info-label {
            color: #a0aec0;
        }

        html.dark-mode .section-title {
            color: #e2e8f0;
        }

        html.dark-mode .comments-box {
            background: #2d3748;
            border-color: #4a5568;
            color: #e2e8f0;
        }

        html.dark-mode .maintenance-table th,
        html.dark-mode .history-table th {
            background: #2d3748;
            border-color: #4a5568;
            color: #e2e8f0;
        }

        html.dark-mode .maintenance-table td,
        html.dark-mode .history-table td {
            background-color: #1a1d2e;
            border-color: #2d3748;
            color: #e2e8f0;
        }

        html.dark-mode .maintenance-row:hover,
        html.dark-mode .history-row:hover {
            background-color: #2d3748;
        }

        html.dark-mode .summary-item {
            background: #2d3748;
            border-color: #4a5568;
        }

        html.dark-mode .summary-label {
            color: #a0aec0;
        }

        html.dark-mode .summary-value {
            color: #e2e8f0;
        }

        html.dark-mode .progress {
            background: #4a5568;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 0 0.5rem;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .dashboard-title {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 1rem !important;
            }

            .maintenance-table-container,
            .history-table-container {
                font-size: 0.8rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .action-buttons .btn {
                width: 100%;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.4s ease forwards;
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
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
            const markDoneButtons = document.querySelectorAll('.btn-mark-done');
            markDoneButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const maintenanceDate = this.getAttribute('data-date');
                    document.getElementById('maintenance_date').value = maintenanceDate;

                    const maintenanceModal = new bootstrap.Modal(document.getElementById('maintenanceModal'));
                    maintenanceModal.show();
                });
            });

            // Add hover effects to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add loading animation to cards
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Add confirmation for status changes
            const statusForms = document.querySelectorAll('form[action*="customers.update"]');
            statusForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const status = this.querySelector('input[name="status"]').value;
                    const action = status === 'active' ? 'activate' : 'set to pending';
                    if (!confirm(`Are you sure you want to ${action} this customer?`)) {
                        e.preventDefault();
                    }
                });
            });
        });

        // Smooth scrolling for better UX
        function smoothScrollToElement(element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
        </script>
        @endsection
