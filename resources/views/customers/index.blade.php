@extends('layouts.app')

@section('content')
@php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
@endphp

<div class="dashboard-container">
    <!-- Modern Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="dashboard-title">Customers</h1>
                <p class="dashboard-subtitle">Manage your customer database and service contracts</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('customers.create') }}" class="btn-add-customer">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Customer</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Compact Search and Filters -->
    <div class="section-card glass-morphism">
        <div class="section-content compact-search">
            <form method="GET" action="{{ route('customers.index') }}" id="searchForm">
                <div class="search-filters-container">
                    <!-- Search Input -->
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-icon">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" id="searchInput"
                                   class="search-input"
                                   placeholder="Search customers..."
                                   value="{{ request('search') }}" autocomplete="off">
                            @if(request('search'))
                            <button type="button" class="clear-search" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                            <span class="input-group-loading" id="searchLoading">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Compact Filter Buttons -->
                    <div class="filter-buttons-compact">
                        <a href="{{ route('customers.index') }}"
                           class="filter-btn {{ !request('status') && !request('contract_status') && !request('maintenance_due') && !request('search') ? 'active' : '' }}"
                           title="All Customers">
                            <i class="fas fa-layer-group"></i>
                            <span>All</span>
                        </a>
                        <a href="{{ route('customers.index') }}?status=active"
                           class="filter-btn success {{ request('status') == 'active' ? 'active' : '' }}"
                           title="Active Customers">
                            <i class="fas fa-check-circle"></i>
                            <span>Active</span>
                        </a>
                        <a href="{{ route('customers.index') }}?contract_status=expiring"
                           class="filter-btn warning {{ request('contract_status') == 'expiring' ? 'active' : '' }}"
                           title="Expiring Soon">
                            <i class="fas fa-clock"></i>
                            <span>Expiring</span>
                        </a>
                        <a href="{{ route('customers.index') }}?contract_status=expired"
                           class="filter-btn danger {{ request('contract_status') == 'expired' ? 'active' : '' }}"
                           title="Expired Contracts">
                            <i class="fas fa-ban"></i>
                            <span>Expired</span>
                        </a>
                        <a href="{{ route('customers.index') }}?maintenance_due=1"
                           class="filter-btn info {{ request('maintenance_due') ? 'active' : '' }}"
                           title="Maintenance Due">
                            <i class="fas fa-tools"></i>
                            <span>Maintenance</span>
                        </a>
                    </div>
                </div>

                <!-- Hidden fields -->
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
        </div>
    </div>

    <!-- Customer List Card -->
    <div class="section-card glass-morphism">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-list"></i>
                <span>Customer List</span>
                @if(request('status') || request('contract_status') || request('maintenance_due') || request('search'))
                    <span class="filter-badge">{{ $customers->total() }} results</span>
                @endif
            </div>
            <div class="section-info">
                @if($customers->total() > 0)
                    <span class="results-count">{{ $customers->firstItem() }}-{{ $customers->lastItem() }}</span>
                    of <span class="results-total">{{ $customers->total() }}</span>
                @else
                    <span class="results-count">No customers</span>
                @endif
            </div>
        </div>

        <div class="section-content" id="customerListContainer">
            @include('customers.partials.customer_list')
        </div>

        <!-- Enhanced Pagination -->
        @if($customers->hasPages())
        <div class="section-footer">
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries
                </div>
                <nav class="pagination-nav">
                    {{ $customers->links('vendor.pagination.custom') }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<style>

<style>
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Modern Header */
.dashboard-header {
    margin-bottom: 1.5rem;
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
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
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

/* Add Customer Button */
.btn-add-customer {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    backdrop-filter: blur(10px);
}

.btn-add-customer:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    background: linear-gradient(135deg, var(--gh-primary-dark), var(--gh-primary));
    color: white;
}

/* Section Cards */
.section-card {
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.section-header {
    padding: 1.25rem 1.5rem;
    background: var(--gh-glass);
    border-bottom: 1px solid var(--gh-glass-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gh-text);
}

.section-title i {
    font-size: 1rem;
    color: var(--gh-primary);
}

.filter-badge {
    background: var(--gh-primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: 0.5rem;
}

.section-info {
    font-size: 0.875rem;
    color: var(--gh-text-light);
}

.results-count {
    font-weight: 600;
    color: var(--gh-text);
}

.section-content {
    background: var(--gh-glass);
}

.section-content.compact-search {
    padding: 1rem 1.5rem;
}

.section-footer {
    padding: 1.25rem 1.5rem;
    background: var(--gh-glass);
    border-top: 1px solid var(--gh-glass-border);
}

/* Compact Search & Filters */
.search-filters-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 250px;
    max-width: 400px;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-group-icon {
    position: absolute;
    left: 1rem;
    color: var(--gh-text-light);
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 1.5px solid var(--gh-glass-border);
    border-radius: 10px;
    background: var(--gh-glass);
    color: var(--gh-text);
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--gh-primary);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.clear-search {
    position: absolute;
    right: 2.5rem;
    background: none;
    border: none;
    color: var(--gh-text-light);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.clear-search:hover {
    color: var(--gh-danger);
    background: rgba(239, 68, 68, 0.1);
}

.input-group-loading {
    position: absolute;
    right: 1rem;
    color: var(--gh-primary);
    display: none;
}

.input-group-loading.show {
    display: block;
}

/* Compact Filter Buttons */
.filter-buttons-compact {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border: 1.5px solid var(--gh-glass-border);
    border-radius: 10px;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--gh-text-light);
    background: var(--gh-glass);
    transition: all 0.3s ease;
    white-space: nowrap;
}

.filter-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.filter-btn.active {
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    color: white;
    border-color: transparent;
}

.filter-btn.success.active {
    background: linear-gradient(135deg, #10b981, #059669);
}

.filter-btn.warning.active {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.filter-btn.danger.active {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.filter-btn.info.active {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
}

/* Customers List */
.customers-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.5rem;
}

.customer-list-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.25rem 1.5rem;
    background: var(--gh-glass);
    border: 1px solid var(--gh-glass-border);
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.customer-list-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    border-radius: 4px 0 0 4px;
}

.customer-list-item.expired::before {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.customer-list-item.maintenance-due::before {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.customer-list-item:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border-color: var(--gh-primary);
}

/* Customer Main Info */
.customer-main-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    min-width: 300px;
}

.customer-avatar {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.customer-details {
    flex: 1;
}

.customer-name-id {
    display: flex;
    align-items: baseline;
    gap: 0.75rem;
    margin-bottom: 0.25rem;
}

.customer-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--gh-text);
    margin: 0;
}

.customer-id {
    font-size: 0.8rem;
    color: var(--gh-text-light);
    font-weight: 500;
}

.customer-contact {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.85rem;
    color: var(--gh-text-light);
}

.customer-contact i {
    width: 14px;
    color: var(--gh-text-light);
}

/* Service Information */
.customer-service-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    min-width: 100px;
}

.service-type {
    padding: 0.3rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.service-type.baiting-system {
    background: rgba(139, 92, 246, 0.1);
    color: #8b5cf6;
}

.service-type.host-system {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.service-price {
    font-weight: 600;
    color: var(--gh-primary);
    font-size: 0.9rem;
}

/* Contract Information */
.customer-contract-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    min-width: 120px;
}

.contract-dates {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.1rem;
}

.contract-dates small {
    color: var(--gh-text-light);
    font-size: 0.75rem;
    white-space: nowrap;
}

.contract-status {
    margin-top: 0.25rem;
}

.status-text {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.status-text.success { color: #10b981; }
.status-text.warning { color: #f59e0b; }
.status-text.danger { color: #ef4444; }

/* Status & Actions */
.customer-status-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    min-width: 200px;
    justify-content: flex-end;
}

.status-badges {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    white-space: nowrap;
}

.status-badge.active {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-badge.pending {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
}

.status-badge.expired {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.status-badge.expiring {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.maintenance-badge {
    color: #f59e0b;
    font-size: 0.875rem;
    padding: 0.35rem;
    background: rgba(245, 158, 11, 0.1);
    border-radius: 50%;
}

.customer-actions {
    display: flex;
    gap: 0.25rem;
}

.action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1.5px solid var(--gh-glass-border);
    background: var(--gh-glass);
    color: var(--gh-text-light);
    font-size: 0.8rem;
}

.action-btn:hover {
    transform: translateY(-1px);
}

.action-btn.map:hover { background: #3b82f6; color: white; border-color: #3b82f6; }
.action-btn.view:hover { background: #0ea5e9; color: white; border-color: #0ea5e9; }
.action-btn.edit:hover { background: #f59e0b; color: white; border-color: #f59e0b; }
.action-btn.delete:hover { background: #ef4444; color: white; border-color: #ef4444; }

.action-form {
    margin: 0;
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
    color: var(--gh-text-light);
}

.empty-icon {
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-content h3 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--gh-text);
}

.empty-content p {
    margin-bottom: 1.5rem;
    font-size: 0.875rem;
}

.empty-content a {
    color: var(--gh-primary);
    text-decoration: none;
}

.empty-content a:hover {
    text-decoration: underline;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pagination-info {
    font-size: 0.875rem;
    color: var(--gh-text-light);
}

.pagination-nav .pagination {
    margin: 0;
}

.pagination-nav .page-link {
    border: 1px solid var(--gh-glass-border);
    color: var(--gh-text);
    border-radius: 8px;
    margin: 0 0.25rem;
    transition: all 0.3s ease;
}

.pagination-nav .page-link:hover {
    background: var(--gh-primary);
    color: white;
    border-color: var(--gh-primary);
}

.pagination-nav .page-item.active .page-link {
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    border-color: var(--gh-primary);
    color: white;
}

/* Glass morphism */
.glass-morphism {
    background: var(--gh-glass);
    backdrop-filter: blur(10px);
    border: 1px solid var(--gh-glass-border);
}

/* Dark mode support */
.dark .glass-morphism {
    background: rgba(30, 30, 30, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.dark .section-card,
.dark .customer-list-item {
    background: rgba(30, 30, 30, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .customer-list-item {
        gap: 1rem;
        padding: 1rem;
    }

    .customer-main-info {
        min-width: 250px;
    }

    .customer-service-info,
    .customer-contract-info {
        min-width: auto;
    }

    .customer-status-actions {
        min-width: 150px;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 0 0.5rem;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .search-filters-container {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .search-box {
        min-width: 100%;
        max-width: 100%;
    }

    .filter-buttons-compact {
        justify-content: center;
    }

    .customer-list-item {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
        padding: 1.25rem;
    }

    .customer-main-info {
        min-width: auto;
    }

    .customer-service-info,
    .customer-contract-info {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .customer-status-actions {
        min-width: auto;
        justify-content: space-between;
    }

    .customer-contact {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }

    .pagination-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .customer-name-id {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }

    .status-badges {
        flex-wrap: wrap;
        justify-content: center;
    }

    .filter-buttons-compact {
        flex-direction: column;
    }

    .filter-btn {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const searchLoading = document.getElementById('searchLoading');
    const customerListContainer = document.getElementById('customerListContainer');
    let searchTimeout;
    let currentController = null;

    searchInput.addEventListener('input', function(e) {
        if (searchLoading) {
            searchLoading.classList.add('show');
        }

        clearTimeout(searchTimeout);

        if (currentController) {
            currentController.abort();
        }

        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 400);
    });

    function performSearch(searchTerm) {
        currentController = new AbortController();

        const url = new URL('{{ route('customers.index') }}');
        const urlParams = new URLSearchParams(window.location.search);

        // Build search parameters
        const params = new URLSearchParams();
        params.set('search', searchTerm);
        params.set('ajax', '1');

        // Preserve existing filters
        ['contract_status', 'maintenance_due', 'status', 'service_type'].forEach(param => {
            if (urlParams.has(param)) {
                params.set(param, urlParams.get(param));
            }
        });

        fetch(`${url}?${params.toString()}`, {
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
            if (data.success && customerListContainer) {
                // Update the customer list
                customerListContainer.innerHTML = data.html;

                // Update pagination if available
                if (data.pagination) {
                    const paginationNav = document.querySelector('.pagination-nav');
                    if (paginationNav) {
                        paginationNav.innerHTML = data.pagination;
                    }
                }

                // Update results count
                updateResultsCount(data.count, data.firstItem, data.lastItem);
            }
        })
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.log('Search failed:', error);
                showErrorMessage('Search failed. Please try again.');
            }
        })
        .finally(() => {
            if (searchLoading) {
                searchLoading.classList.remove('show');
            }
            currentController = null;
        });
    }

    function updateResultsCount(total, firstItem, lastItem) {
        const resultsCount = document.querySelector('.results-count');
        const resultsTotal = document.querySelector('.results-total');
        const sectionInfo = document.querySelector('.section-info');
        const filterBadge = document.querySelector('.filter-badge');
        const paginationInfo = document.querySelector('.pagination-info');

        if (sectionInfo) {
            if (total > 0) {
                sectionInfo.innerHTML = `
                    <span class="results-count">${firstItem}-${lastItem}</span>
                    of <span class="results-total">${total}</span>
                `;
            } else {
                sectionInfo.innerHTML = '<span class="results-count">No customers</span>';
            }
        }

        if (filterBadge && total > 0) {
            filterBadge.textContent = `${total} results`;
        }

        if (paginationInfo) {
            if (total > 0) {
                paginationInfo.textContent = `Showing ${firstItem} to ${lastItem} of ${total} entries`;
            } else {
                paginationInfo.textContent = 'No results found';
            }
        }
    }

    function showErrorMessage(message) {
        // Remove existing error messages
        const existingErrors = document.querySelectorAll('.search-error');
        existingErrors.forEach(error => error.remove());

        // Create error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'search-error';
        errorDiv.style.cssText = `
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            font-size: 0.875rem;
        `;
        errorDiv.textContent = message;

        // Insert after search box
        const searchBox = document.querySelector('.search-box');
        if (searchBox) {
            searchBox.parentNode.insertBefore(errorDiv, searchBox.nextSibling);
        }

        // Auto-hide after 5 seconds
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }

    // Clear search function
    window.clearSearch = function() {
        searchInput.value = '';
        searchInput.focus();
        performSearch('');
    };

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + N for new customer
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.location.href = "{{ route('customers.create') }}";
        }

        // Escape to clear search
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            clearSearch();
        }

        // Focus search with /
        if (e.key === '/' && !e.ctrlKey && !e.metaKey && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
    });

    console.log('GreenHome Customers Index initialized');
});
</script>
@endsection
