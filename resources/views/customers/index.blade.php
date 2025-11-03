<!-- resources/views/customers/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Customers</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Add Customer
    </a>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        id="searchInput"
                        class="form-control" 
                        placeholder="Search by name, customer ID, or phone number..." 
                        value="{{ request('search') }}"
                        autocomplete="off">
                    <button type="button" class="btn btn-outline-secondary d-none" id="clearSearch">
                        <i class="fas fa-times"></i>
                    </button>
                    <span class="input-group-text bg-white d-none" id="loadingSpinner">
                        <i class="fas fa-spinner fa-spin text-primary"></i>
                    </span>
                </div>
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> Search updates automatically as you type
                </small>
            </div>
            <div class="col-md-4 d-flex align-items-start gap-2">
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Customers Table -->
<div class="card">
    <div class="card-body" id="customersTableContainer">
        @include('customers.partials.table')
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const clearBtn = document.getElementById('clearSearch');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const tableContainer = document.getElementById('customersTableContainer');
        let searchTimeout;
        let currentRequest = null;

        function performSearch(searchTerm) {
            // Cancel previous request if still pending
            if (currentRequest) {
                currentRequest.abort();
            }

            // Show loading indicator
            loadingSpinner.classList.remove('d-none');
            
            // Create XMLHttpRequest
            currentRequest = new XMLHttpRequest();
            const url = new URL(window.location.origin + '/customers');
            if (searchTerm) {
                url.searchParams.append('search', searchTerm);
            }

            currentRequest.open('GET', url, true);
            currentRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            currentRequest.onload = function() {
                if (currentRequest.status === 200) {
                    tableContainer.innerHTML = currentRequest.responseText;
                    
                    // Update URL without page reload
                    const newUrl = searchTerm ? url.toString() : window.location.pathname;
                    window.history.pushState({search: searchTerm}, '', newUrl);
                    
                    // Show/hide clear button
                    if (searchTerm) {
                        clearBtn.classList.remove('d-none');
                    } else {
                        clearBtn.classList.add('d-none');
                    }
                    
                    // Re-attach pagination click handlers
                    attachPaginationHandlers();
                }
                loadingSpinner.classList.add('d-none');
                currentRequest = null;
            };

            currentRequest.onerror = function() {
                loadingSpinner.classList.add('d-none');
                currentRequest = null;
            };

            currentRequest.send();
        }

        function attachPaginationHandlers() {
            const paginationLinks = tableContainer.querySelectorAll('.pagination a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get('page');
                    const searchTerm = searchInput.value.trim();
                    
                    loadingSpinner.classList.remove('d-none');
                    
                    const requestUrl = new URL(window.location.origin + '/customers');
                    if (searchTerm) {
                        requestUrl.searchParams.append('search', searchTerm);
                    }
                    if (page) {
                        requestUrl.searchParams.append('page', page);
                    }

                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', requestUrl, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            tableContainer.innerHTML = xhr.responseText;
                            window.history.pushState({}, '', requestUrl.toString());
                            attachPaginationHandlers();
                            
                            // Scroll to top of table
                            tableContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                        loadingSpinner.classList.add('d-none');
                    };
                    
                    xhr.send();
                });
            });
        }

        // Live search as user types
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value.trim();
                
                // Wait 400ms after user stops typing
                searchTimeout = setTimeout(function() {
                    performSearch(searchTerm);
                }, 400);
            });

            // Show clear button if there's initial search value
            if (searchInput.value) {
                clearBtn.classList.remove('d-none');
            }
        }

        // Clear search button
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                clearBtn.classList.add('d-none');
                performSearch('');
                searchInput.focus();
            });
        }

        // Initial pagination handlers
        attachPaginationHandlers();

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(e) {
            const urlParams = new URLSearchParams(window.location.search);
            const searchTerm = urlParams.get('search') || '';
            searchInput.value = searchTerm;
            performSearch(searchTerm);
        });
    });
})();
</script>
@endpush