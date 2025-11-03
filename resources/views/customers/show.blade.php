<!-- resources/views/customers/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Customer Details - {{ $customer->name }}</h4>
                <span class="badge bg-{{ $customer->status == 'active' ? 'success' : 'danger' }}">
                    {{ strtoupper($customer->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Customer ID:</strong> {{ $customer->customer_id }}</p>
                        <p><strong>Name:</strong> {{ $customer->name }}</p>
                        <p><strong>Phone:</strong> {{ $customer->phone_number }}</p>
                        <p><strong>Address:</strong> {{ $customer->address }}</p>
                        @if($customer->google_map_link)
                        <p>
                            <strong>Map:</strong> 
                            <a href="{{ $customer->google_map_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-map-marker-alt"></i> View on Map
                            </a>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p><strong>Service:</strong> {{ $customer->service_name }}</p>
                        <p><strong>Service Type:</strong> {{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</p>
                        <p><strong>Price:</strong> ${{ number_format($customer->service_price, 2) }}</p>
                        <p><strong>Contract Start:</strong> {{ $customer->contract_start_date->format('M d, Y') }}</p>
                        <p><strong>Contract End:</strong> {{ $customer->contract_end_date->format('M d, Y') }}</p>
                        <p class="{{ $customer->isContractExpiring() ? 'text-danger fw-bold' : '' }}">
                            <strong>Days Left:</strong> {{ now()->diffInDays($customer->contract_end_date, false) }} days
                        </p>
                    </div>
                </div>
                
                @if($customer->comments)
                <div class="mt-3">
                    <strong>Comments:</strong>
                    <p class="border p-3 rounded">{{ $customer->comments }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Maintenance History -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Maintenance History</h5>
            </div>
            <div class="card-body">
                @if($maintenanceHistory->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Service Type</th>
                                <th>Performed By</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenanceHistory as $history)
                            <tr>
                                <td>{{ $history->maintenance_date->format('M d, Y') }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $history->service_type)) }}</td>
                                <td>{{ $history->performed_by }}</td>
                                <td>{{ $history->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No maintenance history recorded.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Maintenance Alert -->
        @if($customer->isMaintenanceDue() && $customer->status == 'active')
        <div class="card border-warning mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Maintenance Due</h5>
            </div>
            <div class="card-body">
                <p>Next maintenance scheduled for: <strong>{{ $customer->getNextMaintenanceDate()->format('M d, Y') }}</strong></p>
                <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                    Mark as Maintained
                </button>
            </div>
        </div>
        @endif

        <!-- Contract Actions -->
        @if($customer->isContractExpiring() || $customer->status == 'expired')
        <div class="card border-danger mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-times"></i> Contract Alert</h5>
            </div>
            <div class="card-body">
                @if($customer->status == 'expired')
                <p class="text-danger">Contract expired on {{ $customer->contract_end_date->format('M d, Y') }}</p>
                @else
                <p class="text-danger">Contract expires in {{ now()->diffInDays($customer->contract_end_date, false) }} days</p>
                @endif
                
                <button type="button" class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#renewModal">
                    Renew Contract
                </button>
                
                <form action="{{ route('customers.renew', $customer) }}" method="POST" class="d-inline w-100">
                    @csrf
                    <input type="hidden" name="contract_end_date" value="{{ now()->addYear()->format('Y-m-d') }}">
                    <input type="hidden" name="service_type" value="{{ $customer->service_type }}">
                    <input type="hidden" name="service_price" value="{{ $customer->service_price }}">
                    <button type="submit" class="btn btn-outline-success w-100">
                        Renew for 1 Year
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Customer
                    </a>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                        <i class="fas fa-tools"></i> Record Maintenance
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Modal -->
<div class="modal fade" id="maintenanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Record Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.markMaintenance', $customer) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="maintenance_date" class="form-label">Maintenance Date</label>
                        <input type="date" class="form-control" id="maintenance_date" name="maintenance_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any notes about this maintenance..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Maintenance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Renew Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customers.renew', $customer) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contract_end_date" class="form-label">New Contract End Date</label>
                        <input type="date" class="form-control" id="contract_end_date" name="contract_end_date" value="{{ now()->addYear()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="service_type" class="form-label">Service Type</label>
                        <select class="form-control" id="service_type" name="service_type" required>
                            <option value="baiting_system_complete" {{ $customer->service_type == 'baiting_system_complete' ? 'selected' : '' }}>Baiting System Complete</option>
                            <option value="baiting_system_not_complete" {{ $customer->service_type == 'baiting_system_not_complete' ? 'selected' : '' }}>Baiting System Not Complete</option>
                            <option value="host_system" {{ $customer->service_type == 'host_system' ? 'selected' : '' }}>Host System</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="service_price" class="form-label">Service Price</label>
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
@endsection