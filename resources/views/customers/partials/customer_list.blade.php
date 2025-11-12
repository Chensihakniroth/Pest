@if($customers->count() > 0)
    <div class="list-group list-group-flush" id="customerListContainer">
        @foreach($customers as $customer)
        <div class="list-group-item list-group-item-action border-0 py-3 px-4 customer-list-item
            {{ $customer->hasContractExpired() ? 'expired-item' : '' }}
            {{ $customer->isMaintenanceDue() ? 'maintenance-item' : '' }}"
            style="animation-delay: {{ $loop->index * 0.05 }}s;">

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
