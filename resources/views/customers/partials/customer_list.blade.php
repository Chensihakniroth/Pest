@if($customers->count() > 0)
    <div class="customers-list">
        @foreach($customers as $customer)
        <div class="customer-list-item {{ $customer->hasContractExpired() ? 'expired' : '' }} {{ $customer->isMaintenanceDue() ? 'maintenance-due' : '' }}"
             onclick="window.location='{{ route('customers.show', $customer) }}'">

            <!-- Customer Avatar & Basic Info -->
            <div class="customer-main-info">
                <div class="customer-avatar">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <div class="customer-details">
                    <div class="customer-name-id">
                        <h4 class="customer-name">{{ $customer->name }}</h4>
                        <span class="customer-id">ID: {{ $customer->customer_id }}</span>
                    </div>
                    <div class="customer-contact">
                        <span class="customer-phone">
                            <i class="fas fa-phone"></i>
                            {{ $customer->phone_number }}
                        </span>
                        <span class="customer-address">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ Str::limit($customer->address, 25) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Service Information -->
            <div class="customer-service-info">
                <div class="service-type {{ $customer->service_type === 'host_system' ? 'host-system' : 'baiting-system' }}">
                    {{ $customer->service_type === 'host_system' ? 'Host' : 'Baiting' }}
                </div>
                <div class="service-price">${{ number_format($customer->service_price, 2) }}</div>
            </div>

            <!-- Contract Status -->
            <div class="customer-contract-info">
                <div class="contract-dates">
                    <small>Start: {{ $customer->contract_start_date->format('M d, Y') }}</small>
                    <small>End: {{ $customer->contract_end_date->format('M d, Y') }}</small>
                </div>
                <div class="contract-status">
                    @if($customer->hasContractExpired())
                        <span class="status-text danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $customer->getDaysSinceExpiration() }}d ago
                        </span>
                    @else
                        <span class="status-text {{ $customer->isContractExpiring() ? 'warning' : 'success' }}">
                            <i class="fas fa-calendar"></i>
                            {{ $customer->getDisplayDaysUntilExpiration() }}d left
                        </span>
                    @endif
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="customer-status-actions">
                <div class="status-badges">
                    @if($customer->status == 'pending')
                        <span class="status-badge pending">
                            <i class="fas fa-clock"></i>
                            Pending
                        </span>
                    @elseif($customer->hasContractExpired())
                        <span class="status-badge expired">
                            <i class="fas fa-ban"></i>
                            Expired
                        </span>
                    @elseif($customer->isContractExpiring())
                        <span class="status-badge expiring">
                            <i class="fas fa-clock"></i>
                            Expiring
                        </span>
                    @else
                        <span class="status-badge active">
                            <i class="fas fa-check-circle"></i>
                            Active
                        </span>
                    @endif

                    @if($customer->isMaintenanceDue())
                        <span class="maintenance-badge" title="Maintenance Due">
                            <i class="fas fa-tools"></i>
                        </span>
                    @endif
                </div>

                <div class="customer-actions">
                    @if($customer->google_map_link)
                        <a href="{{ $customer->google_map_link }}" target="_blank" class="action-btn map" title="View on Map" onclick="event.stopPropagation()">
                            <i class="fas fa-map-marker-alt"></i>
                        </a>
                    @endif
                    <a href="{{ route('customers.show', $customer) }}" class="action-btn view" title="View Details" onclick="event.stopPropagation()">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('customers.edit', $customer) }}" class="action-btn edit" title="Edit Customer" onclick="event.stopPropagation()">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="action-form" onclick="event.stopPropagation()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete" title="Delete Customer"
                                onclick="return confirm('Delete {{ $customer->name }}? This action cannot be undone.')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-users fa-3x"></i>
        </div>
        <div class="empty-content">
            <h3>No customers found</h3>
            <p>
                @if(request()->anyFilled(['search', 'service_type', 'status', 'contract_status', 'maintenance_due']))
                    Try adjusting your search criteria or
                    <a href="{{ route('customers.index') }}">clear all filters</a>.
                @else
                    Get started by adding your first customer to the system.
                @endif
            </p>
            @if(!request()->anyFilled(['search', 'service_type', 'status', 'contract_status', 'maintenance_due']))
                <a href="{{ route('customers.create') }}" class="btn-add-customer">
                    <i class="fas fa-plus-circle"></i>
                    Add First Customer
                </a>
            @endif
        </div>
    </div>
@endif
