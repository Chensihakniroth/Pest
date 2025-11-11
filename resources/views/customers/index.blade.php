@extends('layouts.app')

@section('content')
@php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
@endphp

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <h2 class="h3 mb-1 text-dark fw-bold">Customers</h2>
            <p class="text-muted mb-0">Manage your customer database</p>
        </div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add Customer
        </a>
    </div>

    <!-- Simple Filter Bar -->
    <div class="card border-0 shadow-lg mb-4">
        <div class="card-header bg-dark text-white py-3 border-0">
            <h5 class="card-title mb-0 fw-semibold">
                <i class="fas fa-filter me-2"></i>Filters & Search
            </h5>
        </div>
        <div class="card-body bg-light">
            <form action="{{ route('customers.index') }}" method="GET" id="filterForm" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group input-group-sm position-relative">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" id="searchInput" class="form-control border-start-0"
                               placeholder="Search by name, ID, phone, or address..." value="{{ request('search') }}"
                               autocomplete="off">
                        <div class="search-loading position-absolute end-0 top-50 translate-middle-y me-3" style="display: none;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm" name="service_type">
                        <option value="">All Services</option>
                        <option value="baiting_system_complete" {{ request('service_type') == 'baiting_system_complete' ? 'selected' : '' }}>Baiting Complete</option>
                        <option value="baiting_system_not_complete" {{ request('service_type') == 'baiting_system_not_complete' ? 'selected' : '' }}>Baiting Not Complete</option>
                        <option value="host_system" {{ request('service_type') == 'host_system' ? 'selected' : '' }}>Host System</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" name="status" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card border-0 shadow-lg">
        <div class="card-header bg-dark text-white py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">
                    <i class="fas fa-list me-2"></i>Customer List
                </h5>
                <div class="text-white-50 small">
                    @if($customers->total() > 0)
                        Showing <strong>{{ $customers->firstItem() }} - {{ $customers->lastItem() }}</strong>
                        of <strong>{{ $customers->total() }}</strong> customers
                    @else
                        No customers found
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-0 bg-light">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="border-0 ps-4">
                                <div class="d-flex align-items-center">
                                    <span>CUSTOMER</span>
                                    <div class="sort-arrows ms-1">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-white-50 text-decoration-none">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </div>
                                </div>
                            </th>
                            <th class="border-0">
                                <div class="d-flex align-items-center">
                                    <span>SERVICE</span>
                                    <div class="sort-arrows ms-1">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'service_type', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-white-50 text-decoration-none">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </div>
                                </div>
                            </th>
                            <th class="border-0">CONTACT</th>
                            <th class="border-0">
                                <div class="d-flex align-items-center">
                                    <span>STATUS</span>
                                    <div class="sort-arrows ms-1">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'contract_end_date', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-white-50 text-decoration-none">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </div>
                                </div>
                            </th>
                            <th class="border-0 text-end pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody">
                        @forelse($customers as $customer)
                        <tr class="bg-white {{ $customer->hasContractExpired() ? 'table-warning' : '' }}">
                            <!-- Customer Column -->
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3"
                                         style="width: 40px; height: 40px; font-weight: 600;">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $customer->name }}</div>
                                        <small class="text-muted">{{ $customer->customer_id }}</small>
                                        @if($customer->isMaintenanceDue())
                                            <div class="mt-1">
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-tools me-1"></i>Maintenance Due
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Service Column -->
                            <td>
                                <div class="fw-medium text-dark">
                                    {{ $customer->service_type === 'host_system' ? 'Host System' : 'Baiting System' }}
                                </div>
                                <small class="text-muted">${{ number_format($customer->service_price, 2) }}</small>
                            </td>

                            <!-- Contact Column -->
                            <td>
                                <div class="text-dark">{{ $customer->phone_number }}</div>
                                <small class="text-muted" title="{{ $customer->address }}">
                                    {{ Str::limit($customer->address, 25) }}
                                </small>
                            </td>

                            <!-- Status Column -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        @if($customer->status == 'pending')
                                            <!-- Pending Status -->
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-pause me-1"></i>Pending
                                            </span>
                                            <div class="text-muted small mt-1">Contract on hold</div>
                                        @elseif($customer->hasContractExpired())
                                            <!-- Expired Contract -->
                                            <span class="badge bg-danger">Expired</span>
                                            <div class="text-danger small mt-1 fw-semibold">
                                                {{ $customer->getDaysSinceExpiration() }} days ago
                                            </div>
                                        @elseif($customer->isContractExpiring())
                                            <!-- Expiring Contract -->
                                            <span class="badge bg-warning text-dark">Expiring</span>
                                            <div class="text-warning small mt-1 fw-semibold">
                                                {{ $customer->getDisplayDaysUntilExpiration() }} days left
                                            </div>
                                        @else
                                            <!-- Active Status -->
                                            <span class="badge bg-success">Active</span>
                                            <div class="text-success small mt-1 fw-semibold">
                                                {{ $customer->getDisplayDaysUntilExpiration() }} days left
                                            </div>
                                        @endif
                                    </div>
                                    @if($customer->google_map_link)
                                        <a href="{{ $customer->google_map_link }}" target="_blank"
                                           class="btn btn-sm btn-outline-primary ms-2" title="View on Google Maps">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions Column -->
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                onclick="return confirm('Delete {{ $customer->name }}? This cannot be undone.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted bg-white">
                                <i class="fas fa-users fa-2x mb-3"></i>
                                <p class="fw-semibold">No customers found</p>
                                @if(request()->anyFilled(['search', 'service_type', 'status']))
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
        <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }}
                </div>
                <div>
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Customer index page specific initialization
document.addEventListener('DOMContentLoaded', function() {
    // Search and filters are handled by global app.js

    // Add active state to current sort
    const currentSort = '{{ request('sort') }}';
    const currentOrder = '{{ request('order') }}';

    if (currentSort) {
        const sortLinks = document.querySelectorAll(`a[href*="sort=${currentSort}"]`);
        sortLinks.forEach(link => {
            const icon = link.querySelector('i');
            if (icon) {
                icon.className = currentOrder === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down';
                link.classList.add('text-white');
            }
        });
    }
});
</script>
@endsection
