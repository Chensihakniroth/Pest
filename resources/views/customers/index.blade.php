@extends('layouts.app')

@section('content')
@php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
@endphp

<div class="container-fluid px-4 py-4">
    <!-- Enhanced Header with iPhone-style Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark fw-bold">Customers</h1>
            <p class="text-muted mb-0 small">Manage your customer database</p>
        </div>
        <!-- iPhone-style Add Customer Button -->
        <a href="{{ route('customers.create') }}" class="btn-add-customer"
           style="display: inline-flex; align-items: center; gap: 0.5rem;
                  background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
                  color: white; border: none; border-radius: 14px; padding: 0.75rem 1.5rem;
                  text-decoration: none; font-weight: 600; font-size: 0.875rem;
                  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                  box-shadow: 0 4px 16px rgba(25, 135, 84, 0.3);
                  backdrop-filter: blur(10px);">
            <i class="fas fa-plus-circle" style="font-size: 1rem;"></i>
            <span>Add Customer</span>
        </a>
    </div>

    <!-- Compact Search Only (Dropdowns Removed) -->
    <div class="card glass-morphism border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <!-- Search Form -->
            <form method="GET" action="{{ route('customers.index') }}" id="searchForm">
                <div class="row g-2 align-items-center">
                    <div class="col-md-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0 ps-3">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" id="searchInput"
                                   class="form-control border-start-0 modern-input"
                                   placeholder="Search customers by name, ID, phone, or address..."
                                   value="{{ request('search') }}" autocomplete="off">
                            <!-- Loading Spinner -->
                            <span class="input-group-text bg-white border-start-0 pe-3 d-none" id="searchLoading">
                                <i class="fas fa-spinner fa-spin text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Hidden fields to preserve other filters -->
                @if(request('contract_status'))
                    <input type="hidden" name="contract_status" value="{{ request('contract_status') }}">
                @endif
                @if(request('maintenance_due'))
                    <input type="hidden" name="maintenance_due" value="{{ request('maintenance_due') }}">
                @endif
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
            </form>

            <!-- Quick Filters -->
            <div class="mt-3 pt-3 border-top">
                <div class="d-flex flex-wrap gap-1">
                    <a href="{{ route('customers.index') }}"
                       class="btn btn-xs filter-btn {{ !request('status') && !request('contract_status') && !request('maintenance_due') && !request('search') ? 'active' : '' }}">
                        All
                    </a>
                    <a href="{{ route('customers.index') }}?contract_status=active"
                       class="btn btn-xs filter-btn btn-success {{ request('contract_status') == 'active' ? 'active' : '' }}">
                        Active
                    </a>
                    <a href="{{ route('customers.index') }}?contract_status=expiring"
                       class="btn btn-xs filter-btn btn-warning {{ request('contract_status') == 'expiring' ? 'active' : '' }}">
                        Expiring
                    </a>
                    <a href="{{ route('customers.index') }}?contract_status=expired"
                       class="btn btn-xs filter-btn btn-danger {{ request('contract_status') == 'expired' ? 'active' : '' }}">
                        Expired
                    </a>
                    <a href="{{ route('customers.index') }}?maintenance_due=1"
                       class="btn btn-xs filter-btn btn-warning {{ request('maintenance_due') ? 'active' : '' }}">
                        <i class="fas fa-tools me-1"></i>Maintenance
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer List with Scrollbar and Enhanced Pagination -->
    <div class="card glass-morphism border-0 shadow-sm">
        <div class="card-header bg-transparent py-3 px-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-list me-2 text-primary"></i>Customer List
                    @if(request('status') || request('contract_status') || request('maintenance_due') || request('search'))
                        <span class="badge bg-primary ms-2">Filtered</span>
                    @endif
                </h6>
                <div class="text-muted small">
                    @if($customers->total() > 0)
                        <span class="fw-semibold">{{ $customers->firstItem() }}-{{ $customers->lastItem() }}</span>
                        of <span class="fw-semibold">{{ $customers->total() }}</span>
                    @else
                        No customers
                    @endif
                </div>
            </div>
        </div>

        <!-- Scrollable Customer List -->
        <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
            @if($customers->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($customers as $customer)
                    <div class="list-group-item list-group-item-action border-0 py-3 px-4 customer-list-item
                        {{ $customer->hasContractExpired() ? 'expired-item' : '' }}
                        {{ $customer->isMaintenanceDue() ? 'maintenance-item' : '' }}">

                        <div class="row align-items-center">
                            <!-- Customer Info -->
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="customer-avatar bg-gradient-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3"
                                         style="width: 36px; height: 36px; font-weight: 600; font-size: 0.9rem;">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark mb-1">{{ $customer->name }}</div>
                                        <small class="text-muted">ID: {{ $customer->customer_id }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Info -->
                            <div class="col-md-2">
                                <span class="service-badge {{ $customer->service_type === 'host_system' ? 'host-system' : 'baiting-system' }}">
                                    {{ $customer->service_type === 'host_system' ? 'Host' : 'Baiting' }}
                                </span>
                                <div class="text-success fw-semibold small mt-1">${{ number_format($customer->service_price, 2) }}</div>
                            </div>

                            <!-- Contact Info -->
                            <div class="col-md-2">
                                <div class="text-dark small mb-1">{{ $customer->phone_number }}</div>
                                <small class="text-muted">{{ Str::limit($customer->address, 20) }}</small>
                            </div>

                            <!-- Status -->
                            <div class="col-md-2">
                                <div class="d-flex align-items-center gap-2">
                                    @if($customer->status == 'pending')
                                        <span class="status-badge pending">Pending</span>
                                    @elseif($customer->hasContractExpired())
                                        <span class="status-badge expired">Expired</span>
                                    @elseif($customer->isContractExpiring())
                                        <span class="status-badge expiring">Expiring</span>
                                    @else
                                        <span class="status-badge active">Active</span>
                                    @endif

                                    @if($customer->isMaintenanceDue())
                                        <i class="fas fa-tools text-warning" title="Maintenance Due"></i>
                                    @endif
                                </div>
                                <div class="status-detail small mt-1
                                    {{ $customer->hasContractExpired() ? 'text-danger' :
                                       ($customer->isContractExpiring() ? 'text-warning' : 'text-success') }}">
                                    @if($customer->hasContractExpired())
                                        {{ $customer->getDaysSinceExpiration() }}d ago
                                    @else
                                        {{ $customer->getDisplayDaysUntilExpiration() }}d left
                                    @endif
                                </div>
                            </div>

                            <!-- Map -->
                            <div class="col-md-1 text-center">
                                @if($customer->google_map_link)
                                    <a href="{{ $customer->google_map_link }}" target="_blank"
                                       class="btn btn-xs map-btn" title="View on Map">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="col-md-2 text-end">
                                <div class="action-buttons">
                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="btn btn-xs action-btn view-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="btn btn-xs action-btn edit-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs action-btn delete-btn" title="Delete"
                                                onclick="return confirm('Delete {{ $customer->name }}?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-3">
                        <i class="fas fa-users fa-2x text-muted"></i>
                    </div>
                    <h6 class="text-muted mb-3">No customers found</h6>
                    @if(request()->anyFilled(['search', 'service_type', 'status', 'contract_status', 'maintenance_due']))
                        <a href="{{ route('customers.index') }}" class="btn btn-primary btn-sm">
                            Clear filters
                        </a>
                    @else
                        <a href="{{ route('customers.create') }}" class="btn-add-customer" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                            Add first customer
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Enhanced Pagination -->
        @if($customers->hasPages())
        <div class="card-footer bg-transparent py-3 px-4 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $customers->firstItem() }}-{{ $customers->lastItem() }} of {{ $customers->total() }} customers
                </div>
                <div class="pagination-container">
                    <nav aria-label="Customer pagination">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($customers->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" style="border-radius: 10px; margin: 0 2px;">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $customers->previousPageUrl() }}"
                                       style="border-radius: 10px; margin: 0 2px; border: 1px solid var(--gh-border);">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                                @if ($page == $customers->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link"
                                              style="border-radius: 10px; margin: 0 2px;
                                                     background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
                                                     border: none;">
                                            {{ $page }}
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}"
                                           style="border-radius: 10px; margin: 0 2px; border: 1px solid var(--gh-border);">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($customers->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $customers->nextPageUrl() }}"
                                       style="border-radius: 10px; margin: 0 2px; border: 1px solid var(--gh-border);">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" style="border-radius: 10px; margin: 0 2px;">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @endif
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

/* iPhone-style Add Button Hover Effects */
.btn-add-customer:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(25, 135, 84, 0.4);
    background: linear-gradient(135deg, var(--gh-primary-dark), var(--gh-primary)) !important;
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

/* Search Loading Animation */
.search-loading {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Filter Buttons - COLOR CODED */
.filter-btn {
    border-radius: 16px;
    border: 1.5px solid #e9ecef;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
    background: white;
    color: #6c757d;
}

/* Active Filter Button - GREEN */
.filter-btn.btn-success {
    border-color: #198754;
    color: #198754;
    background: rgba(25, 135, 84, 0.1);
}

.filter-btn.btn-success.active,
.filter-btn.btn-success:hover {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    border-color: #198754;
    color: white;
    transform: translateY(-1px);
}

/* Expiring Filter Button - ORANGE/WARNING */
.filter-btn.btn-warning {
    border-color: #ffc107;
    color: #856404;
    background: rgba(255, 193, 7, 0.1);
}

.filter-btn.btn-warning.active,
.filter-btn.btn-warning:hover {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    border-color: #ffc107;
    color: white;
    transform: translateY(-1px);
}

/* Expired Filter Button - RED */
.filter-btn.btn-danger {
    border-color: #dc3545;
    color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

.filter-btn.btn-danger.active,
.filter-btn.btn-danger:hover {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border-color: #dc3545;
    color: white;
    transform: translateY(-1px);
}

/* Default Filter Button */
.filter-btn.active,
.filter-btn:hover:not(.btn-success):not(.btn-warning):not(.btn-danger) {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    border-color: #6c757d;
    color: white;
    transform: translateY(-1px);
}

/* Customer List Items */
.customer-list-item {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f8f9fa !important;
}

.customer-list-item:hover {
    background: rgba(25, 135, 84, 0.03) !important;
    transform: translateX(4px);
}

.customer-list-item:last-child {
    border-bottom: none !important;
}

/* Status Highlights */
.expired-item {
    border-left: 3px solid #dc3545 !important;
}

.maintenance-item {
    border-left: 3px solid #ffc107 !important;
}

/* Customer Avatar */
.customer-avatar {
    transition: all 0.3s ease;
}

.customer-list-item:hover .customer-avatar {
    transform: scale(1.05);
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

.status-detail {
    font-size: 0.75rem;
    font-weight: 600;
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

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.25rem;
    justify-content: flex-end;
}

.action-btn {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: 1.5px solid transparent;
    font-size: 0.7rem;
}

.view-btn {
    background: rgba(13, 202, 240, 0.1);
    color: #0dcaf0;
    border-color: rgba(13, 202, 240, 0.2);
}

.view-btn:hover {
    background: #0dcaf0;
    color: white;
    transform: translateY(-1px);
}

.edit-btn {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
    border-color: rgba(255, 193, 7, 0.2);
}

.edit-btn:hover {
    background: #ffc107;
    color: white;
    transform: translateY(-1px);
}

.delete-btn {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border-color: rgba(220, 53, 69, 0.2);
}

.delete-btn:hover {
    background: #dc3545;
    color: white;
    transform: translateY(-1px);
}

/* Map Button */
.map-btn {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
    border: 1.5px solid rgba(13, 110, 253, 0.2);
    transition: all 0.3s ease;
    font-size: 0.7rem;
}

.map-btn:hover {
    background: #0d6efd;
    color: white;
    transform: translateY(-1px);
}

/* Empty State */
.empty-state-icon {
    opacity: 0.4;
}

/* Custom Scrollbar for Customer List */
.card-body::-webkit-scrollbar {
    width: 6px;
}

.card-body::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 3px;
}

.card-body::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    border-radius: 3px;
}

.card-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #146c43 0%, #0f552f 100%);
}

/* Enhanced Pagination Styles */
.pagination .page-link {
    border: 1px solid var(--gh-border);
    color: var(--gh-text);
    transition: all 0.3s ease;
    font-size: 0.8rem;
    font-weight: 500;
}

.pagination .page-link:hover {
    background: var(--gh-primary);
    color: white;
    border-color: var(--gh-primary);
    transform: translateY(-1px);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    border-color: var(--gh-primary);
    color: white;
}

.pagination .page-item.disabled .page-link {
    background: var(--gh-background);
    border-color: var(--gh-border);
    color: var(--gh-text-light);
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

.dark .filter-btn {
    background: #2d3748;
    border-color: #4a5568;
    color: #e2e8f0;
}

.dark .filter-btn.btn-success {
    border-color: #48bb78;
    color: #48bb78;
    background: rgba(72, 187, 120, 0.1);
}

.dark .filter-btn.btn-warning {
    border-color: #ecc94b;
    color: #ecc94b;
    background: rgba(236, 201, 75, 0.1);
}

.dark .filter-btn.btn-danger {
    border-color: #fc8181;
    color: #fc8181;
    background: rgba(252, 129, 129, 0.1);
}

.dark .customer-list-item {
    border-bottom-color: #4a5568 !important;
}

.dark .customer-list-item:hover {
    background: rgba(72, 187, 120, 0.05) !important;
}

.dark .card-body::-webkit-scrollbar-track {
    background: #2d3748;
}

.dark .card-body::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
}

.dark .card-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
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

    .customer-avatar {
        width: 32px !important;
        height: 32px !important;
    }

    .action-btn {
        width: 26px;
        height: 26px;
    }

    .map-btn {
        width: 26px;
        height: 26px;
    }

    .btn-add-customer {
        padding: 0.6rem 1.2rem !important;
        font-size: 0.8rem !important;
    }
}

/* Smooth Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.customer-list-item {
    animation: slideIn 0.3s ease forwards;
}

/* AJAX Search Animations */
.search-loading {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Fade in animation for AJAX content */
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

.customer-list-item {
    animation: fadeInUp 0.4s ease forwards;
}

/* Stagger animation for list items */
.customer-list-item:nth-child(1) { animation-delay: 0.05s; }
.customer-list-item:nth-child(2) { animation-delay: 0.1s; }
.customer-list-item:nth-child(3) { animation-delay: 0.15s; }
.customer-list-item:nth-child(4) { animation-delay: 0.2s; }
.customer-list-item:nth-child(5) { animation-delay: 0.25s; }
.customer-list-item:nth-child(6) { animation-delay: 0.3s; }
.customer-list-item:nth-child(7) { animation-delay: 0.35s; }
.customer-list-item:nth-child(8) { animation-delay: 0.4s; }
.customer-list-item:nth-child(9) { animation-delay: 0.45s; }
.customer-list-item:nth-child(10) { animation-delay: 0.5s; }

/* Smooth transitions for search container */
.search-transition {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Loading overlay */
.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    border-radius: 12px;
}

.dark .loading-overlay {
    background: rgba(30, 30, 30, 0.8);
}

/* Stagger animation */
.customer-list-item:nth-child(1) { animation-delay: 0.1s; }
.customer-list-item:nth-child(2) { animation-delay: 0.15s; }
.customer-list-item:nth-child(3) { animation-delay: 0.2s; }
.customer-list-item:nth-child(4) { animation-delay: 0.25s; }
.customer-list-item:nth-child(5) { animation-delay: 0.3s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchLoading = document.getElementById('searchLoading');
    let searchTimeout;
    let currentController = null;

    // Simple AJAX search that only updates the list and pagination
    searchInput.addEventListener('input', function(e) {
        // Show loading spinner
        if (searchLoading) {
            searchLoading.classList.remove('d-none');
        }

        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Cancel previous request if still pending
        if (currentController) {
            currentController.abort();
        }

        // Set new timeout for search execution
        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 300);
    });

    function performSearch(searchTerm) {
        // Create new AbortController for this request
        currentController = new AbortController();

        // Build URL with current parameters
        const url = new URL('{{ route('customers.index') }}');
        url.searchParams.set('search', searchTerm);
        url.searchParams.set('ajax', '1');

        // Preserve existing filters
        const urlParams = new URLSearchParams(window.location.search);
        ['contract_status', 'maintenance_due', 'status', 'service_type'].forEach(param => {
            if (urlParams.has(param)) {
                url.searchParams.set(param, urlParams.get(param));
            }
        });

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            signal: currentController.signal
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update only the customer list container
                const listContainer = document.querySelector('.card-body .list-group');
                const emptyState = document.querySelector('.card-body .text-center');

                if (data.html) {
                    if (listContainer) {
                        listContainer.outerHTML = data.html;
                    } else if (emptyState) {
                        emptyState.outerHTML = data.html;
                    } else {
                        document.querySelector('.card-body').innerHTML = data.html;
                    }
                }

                // Update pagination
                const paginationContainer = document.querySelector('.card-footer');
                if (data.pagination && paginationContainer) {
                    paginationContainer.outerHTML = data.pagination;
                } else if (!data.hasPages && paginationContainer) {
                    paginationContainer.remove();
                } else if (data.hasPages && data.pagination && !paginationContainer) {
                    // Add pagination if it doesn't exist
                    document.querySelector('.card').insertAdjacentHTML('beforeend', data.pagination);
                }

                // Update the count in header
                updateResultsCount(data.count, data.firstItem, data.lastItem);

                // Re-attach click events to new list items
                attachListItemEvents();
            }
        })
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.log('Search failed, falling back to regular form');
                // Fallback: submit the form normally
                document.getElementById('searchForm').submit();
            }
        })
        .finally(() => {
            // Hide loading spinner
            if (searchLoading) {
                searchLoading.classList.add('d-none');
            }
            currentController = null;
        });
    }

    function updateResultsCount(total, firstItem, lastItem) {
        const countElement = document.querySelector('.card-header .text-muted.small');
        if (countElement) {
            if (total > 0) {
                countElement.innerHTML = `<span class="fw-semibold">${firstItem}-${lastItem}</span> of <span class="fw-semibold">${total}</span>`;
            } else {
                countElement.textContent = 'No customers';
            }
        }

        // Update filter badge
        const header = document.querySelector('.card-header h6');
        const hasFilters = searchInput.value || window.location.search.includes('contract_status') ||
                          window.location.search.includes('maintenance_due') ||
                          window.location.search.includes('status');

        let filterBadge = header.querySelector('.badge');
        if (hasFilters && !filterBadge) {
            header.innerHTML += ' <span class="badge bg-primary ms-2">Filtered</span>';
        } else if (!hasFilters && filterBadge) {
            filterBadge.remove();
        }
    }

    function attachListItemEvents() {
        // Re-attach click events to list items
        document.querySelectorAll('.customer-list-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (!e.target.closest('.action-buttons') &&
                    !e.target.closest('.map-btn') &&
                    !e.target.closest('button') &&
                    !e.target.closest('a') &&
                    !e.target.closest('form')) {

                    const viewLink = this.querySelector('a[href*="/customers/"]');
                    if (viewLink) {
                        window.location.href = viewLink.href;
                    }
                }
            });
        });
    }

    // Clear search on Escape key
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            this.value = '';
            clearTimeout(searchTimeout);
            if (currentController) {
                currentController.abort();
            }
            performSearch('');
        }
    });

    // Enhanced filter buttons with AJAX
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            // Show loading
            if (searchLoading) {
                searchLoading.classList.remove('d-none');
            }

            fetch(this.href + '&ajax=1', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the page content
                    const listContainer = document.querySelector('.card-body .list-group');
                    const emptyState = document.querySelector('.card-body .text-center');

                    if (data.html) {
                        if (listContainer) {
                            listContainer.outerHTML = data.html;
                        } else if (emptyState) {
                            emptyState.outerHTML = data.html;
                        }
                    }

                    // Update pagination
                    const paginationContainer = document.querySelector('.card-footer');
                    if (data.pagination && paginationContainer) {
                        paginationContainer.outerHTML = data.pagination;
                    }

                    updateResultsCount(data.count, data.firstItem, data.lastItem);
                    attachListItemEvents();

                    // Update URL without reload
                    window.history.pushState({}, '', this.href);
                }
            })
            .finally(() => {
                if (searchLoading) {
                    searchLoading.classList.add('d-none');
                }
            });
        });
    });

    // Handle browser navigation
    window.addEventListener('popstate', function() {
        performSearch(searchInput.value);
    });

    // Keyboard shortcuts (keep your existing ones)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
        if (e.key === '+' && !e.ctrlKey && !e.metaKey) {
            e.preventDefault();
            document.querySelector('.btn-add-customer').click();
        }
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            searchInput.blur();
        }
    });

    // Initial setup
    if (searchInput.value) {
        searchInput.focus();
    }
    attachListItemEvents();
});
</script>
@endsection
