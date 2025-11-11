@extends('layouts.app')

@section('content')
@php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
@endphp

<div class="container-fluid px-3">
    <!-- Compact Header -->
    <div class="d-flex justify-content-between align-items-center py-3">
        <div>
            <h2 class="h4 mb-1 text-dark fw-bold">Customers</h2>
            <p class="text-muted mb-0 small">Manage your customer database</p>
        </div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add Customer
        </a>
    </div>

    <!-- Compact Filter Bar -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-dark text-white py-2 px-3">
            <h6 class="card-title mb-0 fw-semibold">
                <i class="fas fa-filter me-1"></i>Filters & Search
            </h6>
        </div>
        <div class="card-body bg-light p-3">
            <form action="{{ route('customers.index') }}" method="GET" id="filterForm" class="row g-2 align-items-center">
                <div class="col-md-8">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="searchInput" class="form-control border-start-0"
                               placeholder="Search customers..." value="{{ request('search') }}"
                               autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-1">
                        <a href="{{ route('customers.index') }}" class="btn btn-sm btn-outline-secondary flex-fill">
                            <i class="fas fa-undo me-1"></i> Clear
                        </a>
                    </div>
                </div>
            </form>

            <!-- Quick Status Filters -->
            <div class="row mt-2">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('customers.index') }}" class="btn btn-sm btn-outline-dark {{ !request('status') && !request('maintenance_due') ? 'active' : '' }}">
                            All ({{ $totalCustomers ?? 0 }})
                        </a>
                        <a href="{{ route('customers.index') }}?status=active" class="btn btn-sm btn-outline-success {{ request('status') == 'active' ? 'active' : '' }}">
                            Active ({{ $statusCounts['active'] ?? 0 }})
                        </a>
                        <a href="{{ route('customers.index') }}?status=expired" class="btn btn-sm btn-outline-danger {{ request('status') == 'expired' ? 'active' : '' }}">
                            Expired ({{ $statusCounts['expired'] ?? 0 }})
                        </a>
                        <a href="{{ route('customers.index') }}?status=pending" class="btn btn-sm btn-outline-warning {{ request('status') == 'pending' ? 'active' : '' }}">
                            Pending ({{ $statusCounts['pending'] ?? 0 }})
                        </a>
                        <a href="{{ route('customers.index') }}?maintenance_due=1" class="btn btn-sm btn-outline-warning {{ request('maintenance_due') ? 'active' : '' }}">
                            <i class="fas fa-tools me-1"></i> Maintenance Due
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compact Customers Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white py-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0 fw-semibold">
                    <i class="fas fa-list me-1"></i>Customer List
                    @if(request('status'))
                        <span class="badge bg-{{ request('status') == 'active' ? 'success' : (request('status') == 'expired' ? 'danger' : 'warning') }} ms-2">
                            {{ ucfirst(request('status')) }}
                        </span>
                    @endif
                    @if(request('maintenance_due'))
                        <span class="badge bg-warning text-dark ms-2">Maintenance Due</span>
                    @endif
                </h6>
                <div class="text-white-50 small">
                    @if($customers->total() > 0)
                        <strong>{{ $customers->firstItem() }}-{{ $customers->lastItem() }}</strong> of <strong>{{ $customers->total() }}</strong>
                    @else
                        No customers found
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-0 bg-light">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-0 ps-3" style="width: 25%">CUSTOMER</th>
                            <th class="border-0" style="width: 20%">SERVICE</th>
                            <th class="border-0" style="width: 20%">CONTACT</th>
                            <th class="border-0" style="width: 15%">STATUS</th>
                            <th class="border-0" style="width: 10%">MAP</th>
                            <th class="border-0 text-end pe-3" style="width: 10%">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody">
                        @forelse($customers as $customer)
                        <tr class="bg-white customer-row {{ $customer->hasContractExpired() ? 'table-warning' : '' }} {{ $customer->isMaintenanceDue() ? 'maintenance-due' : '' }}">
                            <!-- Customer Column -->
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="customer-avatar bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2"
                                         style="width: 32px; height: 32px; font-weight: 600; font-size: 0.8rem;">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark customer-name small">{{ $customer->name }}</div>
                                        <small class="text-muted customer-id">{{ $customer->customer_id }}</small>
                                        @if($customer->isMaintenanceDue())
                                            <div class="mt-1">
                                                <span class="badge bg-warning text-dark maintenance-badge" style="font-size: 0.65rem;">
                                                    <i class="fas fa-tools me-1"></i>Maintenance Due
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Service Column -->
                            <td>
                                <div class="fw-medium text-dark service-type small">
                                    {{ $customer->service_type === 'host_system' ? 'Host System' : 'Baiting System' }}
                                </div>
                                <small class="text-muted service-price">${{ number_format($customer->service_price, 2) }}</small>
                            </td>

                            <!-- Contact Column -->
                            <td>
                                <div class="text-dark customer-phone small">{{ $customer->phone_number }}</div>
                                <small class="text-muted customer-address" title="{{ $customer->address }}">
                                    {{ Str::limit($customer->address, 20) }}
                                </small>
                            </td>

                            <!-- Status Column -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        @if($customer->status == 'pending')
                                            <span class="badge bg-secondary status-badge" style="font-size: 0.7rem;">
                                                <i class="fas fa-pause me-1"></i>Pending
                                            </span>
                                        @elseif($customer->hasContractExpired())
                                            <span class="badge bg-danger status-badge" style="font-size: 0.7rem;">Expired</span>
                                            <div class="text-danger small mt-1 fw-semibold">
                                                {{ $customer->getDaysSinceExpiration() }}d ago
                                            </div>
                                        @elseif($customer->isContractExpiring())
                                            <span class="badge bg-warning text-dark status-badge" style="font-size: 0.7rem;">Expiring</span>
                                            <div class="text-warning small mt-1 fw-semibold">
                                                {{ $customer->getDisplayDaysUntilExpiration() }}d left
                                            </div>
                                        @else
                                            <span class="badge bg-success status-badge" style="font-size: 0.7rem;">Active</span>
                                            <div class="text-success small mt-1 fw-semibold">
                                                {{ $customer->getDisplayDaysUntilExpiration() }}d left
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Map Column -->
                            <td>
                                @if($customer->google_map_link)
                                    <a href="{{ $customer->google_map_link }}" target="_blank" class="btn btn-sm btn-outline-primary map-btn" title="View on Google Maps">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">No map</span>
                                @endif
                            </td>

                            <!-- Actions Column -->
                            <td class="text-end pe-3">
                                <div class="btn-group action-buttons">
                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="btn btn-sm btn-outline-secondary" title="Edit Customer">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Customer"
                                                onclick="return confirm('Delete {{ $customer->name }}? This cannot be undone.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted bg-white">
                                <i class="fas fa-users fa-lg mb-2"></i>
                                <p class="fw-semibold small">No customers found</p>
                                @if(request()->anyFilled(['search', 'service_type', 'status', 'maintenance_due']))
                                    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-outline-primary">
                                        Clear filters
                                    </a>
                                @else
                                    <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary">
                                        Add your first customer
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($customers->hasPages())
        <div class="card-footer bg-white border-0 py-2 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    {{ $customers->firstItem() }}-{{ $customers->lastItem() }} of {{ $customers->total() }} customers
                </div>
                <div>
                    {{ $customers->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* Compact table styles */
.customer-row {
    transition: all 0.2s ease;
    border-bottom: 1px solid transparent;
}

.customer-row:hover {
    background-color: #f8f9fa !important;
    transform: translateX(2px);
    border-bottom-color: #dee2e6;
}

.customer-avatar {
    transition: all 0.2s ease;
}

.customer-row:hover .customer-avatar {
    transform: scale(1.05);
}

/* Status badges */
.status-badge {
    font-size: 0.7rem;
    padding: 0.3em 0.6em;
}

/* Maintenance due highlighting */
.maintenance-due {
    border-left: 3px solid #ffc107 !important;
}

/* Action buttons */
.action-buttons .btn {
    transition: all 0.2s ease;
    border-radius: 4px;
    padding: 0.25rem 0.4rem;
}

.action-buttons .btn:hover {
    transform: translateY(-1px);
}

/* Map button */
.map-btn {
    transition: all 0.2s ease;
    border-radius: 6px;
    padding: 0.3rem 0.5rem;
}

.map-btn:hover {
    transform: translateY(-1px);
    background-color: #0d6efd;
    color: white;
}

/* Quick filter buttons */
.btn-outline-success.active,
.btn-outline-danger.active,
.btn-outline-warning.active,
.btn-outline-dark.active {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}

/* Table responsive improvements */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.8rem;
    }

    .action-buttons .btn {
        padding: 0.2rem 0.3rem;
        font-size: 0.7rem;
    }

    .map-btn {
        padding: 0.25rem 0.4rem;
        font-size: 0.7rem;
    }

    .customer-avatar {
        width: 28px !important;
        height: 28px !important;
        font-size: 0.7rem;
    }

    .d-flex.flex-wrap .btn {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
}

/* Smooth animations */
.card {
    transition: all 0.2s ease;
}

/* Enhanced filter section */
.bg-light {
    background-color: #fafbfc !important;
}

/* Auto-refresh indicator */
.auto-refresh-indicator {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

/* Compact pagination */
.pagination .page-link {
    border-radius: 4px;
    margin: 0 1px;
    border: 1px solid #dee2e6;
    font-size: 0.8rem;
    padding: 0.3rem 0.6rem;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    border-color: #198754;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize customer index page
    initializeCustomerIndex();

    function initializeCustomerIndex() {
        // Enhanced search with debounce
        initializeSearch();
        // Quick filter enhancements
        initializeQuickFilters();
        // Row click handlers
        initializeRowInteractions();
    }

    // Debounced search functionality
    function initializeSearch() {
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 800);
        });
    }

    // Quick filter enhancements
    function initializeQuickFilters() {
        const quickFilterButtons = document.querySelectorAll('.d-flex.flex-wrap .btn');

        // Highlight active filter
        const currentUrl = new URL(window.location.href);
        const currentStatus = currentUrl.searchParams.get('status');
        const currentMaintenance = currentUrl.searchParams.get('maintenance_due');

        quickFilterButtons.forEach(button => {
            const buttonUrl = new URL(button.href);
            const buttonStatus = buttonUrl.searchParams.get('status');
            const buttonMaintenance = buttonUrl.searchParams.get('maintenance_due');

            if ((currentStatus && buttonStatus === currentStatus) ||
                (currentMaintenance && buttonMaintenance === currentMaintenance) ||
                (!currentStatus && !currentMaintenance && button.href === window.location.origin + '/customers')) {
                button.classList.add('active');
            }
        });
    }

    // Row interactions
    function initializeRowInteractions() {
        const customerRows = document.querySelectorAll('.customer-row');
        customerRows.forEach(row => {
            // Make entire row clickable (except action buttons and map button)
            row.addEventListener('click', function(e) {
                if (!e.target.closest('.action-buttons') && !e.target.closest('.map-btn') && !e.target.closest('a') && !e.target.closest('button')) {
                    const viewLink = this.querySelector('a[href*="/customers/"]');
                    if (viewLink) {
                        window.location.href = viewLink.href;
                    }
                }
            });

            // Add hover effects
            row.addEventListener('mouseenter', function() {
                this.style.cursor = 'pointer';
            });
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            document.getElementById('searchInput').focus();
        }

        // Ctrl/Cmd + N for new customer
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.location.href = '{{ route('customers.create') }}';
        }
    });
});
</script>
@endsection
