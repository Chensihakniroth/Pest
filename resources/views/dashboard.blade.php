@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <h2 class="h3 mb-1 text-dark fw-bold">Dashboard</h2>
            <p class="text-muted mb-0">Welcome to Green Home Pest Control Management</p>
        </div>
        <div class="text-muted small bg-light px-3 py-2 rounded auto-refresh-indicator">
            <i class="fas fa-sync-alt me-1"></i> Auto-updates every 60 seconds
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small text-white-50 text-uppercase fw-semibold">Total Customers</div>
                            <div class="h3 mb-0 fw-bold" data-stat="total-customers">{{ $totalCustomers ?? 0 }}</div>
                            <div class="small mt-1 text-white-50">
                                <i class="fas fa-users me-1"></i>All registered clients
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white-20 rounded-circle p-3">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small text-white-50 text-uppercase fw-semibold">Active Customers</div>
                            <div class="h3 mb-0 fw-bold" data-stat="active-customers">{{ $activeCustomers ?? 0 }}</div>
                            <div class="small mt-1 text-white-50">
                                <i class="fas fa-check-circle me-1"></i>Current contracts
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white-20 rounded-circle p-3">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small text-white-50 text-uppercase fw-semibold">Expiring Contracts</div>
                            <div class="h3 mb-0 fw-bold" data-stat="expiring-contracts">{{ $expiringContracts ?? 0 }}</div>
                            <div class="small mt-1 text-white-50">
                                <i class="fas fa-clock me-1"></i>Within 90 days
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white-20 rounded-circle p-3">
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="small text-white-50 text-uppercase fw-semibold">Maintenance Due</div>
                            <div class="h3 mb-0 fw-bold" data-stat="maintenance-alerts">{{ $maintenanceAlertsCount ?? 0 }}</div>
                            <div class="small mt-1 text-white-50">
                                <i class="fas fa-tools me-1"></i>Requires attention
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-white-20 rounded-circle p-3">
                                <i class="fas fa-tools fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="row g-4">
        <!-- Maintenance Alerts -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-semibold">
                            <i class="fas fa-tools me-2"></i>Maintenance Alerts
                        </h5>
                        <span class="badge bg-warning text-dark">{{ $maintenanceAlertsCount ?? 0 }}</span>
                    </div>
                </div>
                <div class="card-body p-0 bg-light">
                    <div class="alert-container" style="max-height: 400px; overflow-y: auto;">
                        @if(($maintenanceAlertsCount ?? 0) > 0)
                            @foreach($maintenanceAlerts ?? [] as $maintenanceAlert)
                                @php
                                    $customer = $maintenanceAlert['customer'] ?? null;
                                    $alert = $maintenanceAlert['alert'] ?? null;
                                    if ($customer) {
                                        $isCompleted = $customer->isMaintenanceDateCompleted($alert['date'] ?? null);
                                    } else {
                                        $isCompleted = true;
                                    }
                                @endphp

                                @if(!$isCompleted && $customer && $alert)
                                <div class="border-bottom border-light p-3 bg-white">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3"
                                                     style="width: 36px; height: 36px; font-weight: 600; font-size: 0.875rem;">
                                                    {{ strtoupper(substr($customer->name ?? '', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $customer->name ?? 'Unknown' }}</div>
                                                    <small class="text-muted">{{ $customer->customer_id ?? '' }}</small>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge bg-{{ ($customer->service_type ?? '') === 'host_system' ? 'info' : 'primary' }}">
                                                    {{ ($customer->service_type ?? '') === 'host_system' ? 'Host' : 'Baiting' }}
                                                </span>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $alert['date']->format('M d, Y') ?? 'Unknown Date' }}
                                                </small>
                                                <small class="text-{{ ($alert['type'] ?? '') === 'overdue' ? 'danger' : 'warning' }} fw-semibold">
                                                    <i class="fas fa-clock me-1"></i>
                                                    @if(($alert['type'] ?? '') === 'overdue')
                                                        Overdue by {{ abs($alert['days'] ?? 0) }} days
                                                    @else
                                                        Due in {{ $alert['days'] ?? 0 }} days
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        @if($customer)
                                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted bg-white">
                                <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                                <p class="mb-0 fw-semibold">No maintenance alerts</p>
                                <small class="text-muted">All maintenance is up to date</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Contract Alerts -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-semibold">
                            <i class="fas fa-calendar-times me-2"></i>Contract Expiration Alerts
                        </h5>
                        <span class="badge bg-danger">{{ $contractAlertsCount ?? 0 }}</span>
                    </div>
                </div>
                <div class="card-body p-0 bg-light">
                    <div class="alert-container" style="max-height: 400px; overflow-y: auto;">
                        @if(($contractAlertsCount ?? 0) > 0)
                            @foreach($contractAlerts ?? [] as $customer)
                            @php
                                $daysLeft = $customer->getDisplayDaysUntilExpiration() ?? 0;
                            @endphp
                            <div class="border-bottom border-light p-3 bg-white">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3"
                                                 style="width: 36px; height: 36px; font-weight: 600; font-size: 0.875rem;">
                                                {{ strtoupper(substr($customer->name ?? '', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $customer->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ $customer->customer_id ?? '' }}</small>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-3">
                                            <span class="badge bg-{{ $daysLeft <= 7 ? 'danger' : ($daysLeft <= 30 ? 'warning text-dark' : 'secondary') }}">
                                                {{ $daysLeft }} days left
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                Expires: {{ $customer->contract_end_date->format('M d, Y') ?? 'Unknown' }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-tag me-1"></i>
                                                {{ ucfirst(str_replace('_', ' ', $customer->service_type ?? '')) }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted bg-white">
                                <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                                <p class="mb-0 fw-semibold">No contract alerts</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expired Contracts Section -->
    @if(isset($expiredContracts) && ($expiredContractsCount ?? 0) > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-ban me-2"></i>Expired Contracts
                        <span class="badge bg-danger ms-2">{{ $expiredContractsCount ?? 0 }}</span>
                    </h5>
                </div>
                <div class="card-body p-0 bg-light">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="border-0 ps-4">Customer</th>
                                    <th class="border-0">Service Type</th>
                                    <th class="border-0">Contract End Date</th>
                                    <th class="border-0">Days Expired</th>
                                    <th class="border-0 text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expiredContracts ?? [] as $customer)
                                @php
                                    $daysExpired = $customer->getDaysSinceExpiration() ?? 0;
                                @endphp
                                <tr class="bg-white">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3"
                                                 style="width: 36px; height: 36px; font-weight: 600; font-size: 0.875rem;">
                                                {{ strtoupper(substr($customer->name ?? '', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $customer->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ $customer->customer_id ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ ($customer->service_type ?? '') === 'host_system' ? 'info' : 'primary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $customer->service_type ?? '')) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $customer->contract_end_date->format('M d, Y') ?? 'Unknown' }}</td>
                                    <td>
                                        <span class="badge bg-dark">{{ $daysExpired }} days</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
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

    <!-- Quick Actions - FIXED SORTING LINKS -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">Quick Actions</h5>
                </div>
                <div class="card-body bg-light">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('customers.create') }}" class="btn btn-primary w-100 h-100 py-3">
                                <i class="fas fa-plus-circle fa-lg me-2"></i>
                                <div class="fw-semibold">Add New Customer</div>
                                <small class="d-block mt-1 opacity-75">Create new client</small>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customers.index') }}?status=active&sort=contract_end_date&order=asc" class="btn btn-success w-100 h-100 py-3">
                                <i class="fas fa-check-circle fa-lg me-2"></i>
                                <div class="fw-semibold">Active Customers</div>
                                <small class="d-block mt-1 opacity-75">Sorted by expiry date</small>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customers.index') }}?status=expired&sort=contract_end_date&order=desc" class="btn btn-danger w-100 h-100 py-3">
                                <i class="fas fa-ban fa-lg me-2"></i>
                                <div class="fw-semibold">Expired Contracts</div>
                                <small class="d-block mt-1 opacity-75">Most recent first</small>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customers.index') }}?sort=name&order=asc" class="btn btn-info w-100 h-100 py-3">
                                <i class="fas fa-search fa-lg me-2"></i>
                                <div class="fw-semibold">All Customers</div>
                                <small class="d-block mt-1 opacity-75">A-Z sorted</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.75rem 2.5rem rgba(0, 0, 0, 0.15) !important;
}

/* Enhanced gradient backgrounds with Green Home branding */
.bg-gradient-primary {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #198754 0%, #0f5132 100%) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
}

.bg-white-20 {
    background: rgba(255, 255, 255, 0.2) !important;
}

/* Enhanced shadows */
.shadow-lg {
    box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.1) !important;
}

/* Table styling */
.table th {
    font-weight: 600;
    font-size: 0.875rem;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-bottom: 1px solid #f8f9fa;
}

.btn-group .btn {
    border-radius: 6px;
    margin: 0 2px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
    font-weight: 600;
}

.bg-light {
    background-color: #f8f9fa !important;
}

/* Alert container styling */
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

.border-bottom:last-child {
    border-bottom: none !important;
}

/* Quick action buttons */
.btn {
    transition: all 0.3s ease-in-out;
    position: relative;
    overflow: hidden;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.btn:active {
    transform: translateY(0);
}

/* Header contrast */
.bg-dark {
    background-color: #2c3e50 !important;
}

/* Loading animation for auto-refresh */
.auto-refresh-indicator {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

/* Enhanced auto-refresh indicators */
.auto-refresh-indicator.updating {
    animation: pulseUpdate 1s ease-in-out;
}

@keyframes pulseUpdate {
    0% { opacity: 1; }
    50% { opacity: 0.6; transform: scale(0.98); }
    100% { opacity: 1; transform: scale(1); }
}

/* Stat card enhancements */
.stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

/* Loading states */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-right-color: transparent;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh dashboard every 60 seconds
    let refreshTimer = setInterval(function() {
        refreshDashboardStats();
    }, 60000);

    // Add smooth scrolling to alerts
    const alertContainers = document.querySelectorAll('.alert-container');
    alertContainers.forEach(container => {
        if (container.scrollHeight > container.clientHeight) {
            container.style.scrollBehavior = 'smooth';
        }
    });

    // Enhanced quick action buttons with loading states
    const quickActionButtons = document.querySelectorAll('.btn-group .btn, .quick-actions .btn');
    quickActionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add loading state for actions that might take time
            if (this.href && !this.href.includes('#')) {
                this.classList.add('btn-loading');
                setTimeout(() => {
                    this.classList.remove('btn-loading');
                }, 2000);
            }
        });
    });

    // Add visual feedback for card interactions
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Only trigger if not clicking interactive elements
            if (!e.target.closest('a') && !e.target.closest('button')) {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            }
        });
    });

    // AJAX stats refresh function
    function refreshDashboardStats() {
        if (window.location.pathname === '/dashboard' || window.location.pathname === '/') {
            fetch('/dashboard/stats')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    updateDashboardStats(data);
                })
                .catch(error => {
                    console.log('Auto-refresh failed, will reload page');
                    window.location.reload();
                });
        }
    }

    // Update stats on the page without full reload
    function updateDashboardStats(stats) {
        // Update total customers
        const totalEl = document.querySelector('[data-stat="total-customers"]');
        if (totalEl && totalEl.textContent != stats.totalCustomers) {
            totalEl.textContent = stats.totalCustomers;
            showStatsUpdateIndicator(totalEl);
        }

        // Update active customers
        const activeEl = document.querySelector('[data-stat="active-customers"]');
        if (activeEl && activeEl.textContent != stats.activeCustomers) {
            activeEl.textContent = stats.activeCustomers;
            showStatsUpdateIndicator(activeEl);
        }

        // Update expiring contracts
        const expiringEl = document.querySelector('[data-stat="expiring-contracts"]');
        if (expiringEl && expiringEl.textContent != stats.expiringContracts) {
            expiringEl.textContent = stats.expiringContracts;
            showStatsUpdateIndicator(expiringEl);
        }

        // Update maintenance alerts count
        const maintenanceEl = document.querySelector('[data-stat="maintenance-alerts"]');
        if (maintenanceEl && maintenanceEl.textContent != stats.maintenanceAlertsCount) {
            maintenanceEl.textContent = stats.maintenanceAlertsCount;
            showStatsUpdateIndicator(maintenanceEl);
        }

        // Update last updated time
        const lastUpdatedEl = document.querySelector('.auto-refresh-indicator');
        if (lastUpdatedEl) {
            lastUpdatedEl.innerHTML = `<i class="fas fa-sync-alt me-1"></i> Updated: ${new Date().toLocaleTimeString()}`;
        }
    }

    // Show visual feedback when stats update
    function showStatsUpdateIndicator(element) {
        element.classList.add('updating');
        setTimeout(() => {
            element.classList.remove('updating');
        }, 1000);
    }

    // Initialize real-time stats
    function initializeRealTimeStats() {
        const lastUpdatedEl = document.querySelector('.text-muted.small.bg-light');
        if (lastUpdatedEl) {
            lastUpdatedEl.classList.add('auto-refresh-indicator');
        }
    }

    initializeRealTimeStats();
});
</script>
@endsection
