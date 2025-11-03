<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Statistics -->
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalCustomers }}</h4>
                        <p>Total Customers</p>
                    </div>
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $activeCustomers }}</h4>
                        <p>Active Customers</p>
                    </div>
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $expiringContracts }}</h4>
                        <p>Expiring Contracts</p>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alerts Section -->
<div class="row">
    <!-- Maintenance Alerts -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tools"></i> Maintenance Alerts
                </h5>
            </div>
            <div class="card-body">
                @if($maintenanceAlerts->count() > 0)
                    @foreach($maintenanceAlerts as $customer)
                    <div class="alert alert-warning d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $customer->name }}</strong> ({{ $customer->customer_id }})<br>
                            <small>Next Maintenance: {{ $customer->getNextMaintenanceDate()->format('M d, Y') }}</small>
                        </div>
                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                            View
                        </a>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">No maintenance alerts</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Contract Alerts -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-times"></i> Contract Expiration Alerts
                </h5>
            </div>
            <div class="card-body">
                @if($contractAlerts->count() > 0)
                    @foreach($contractAlerts as $customer)
                    <div class="alert alert-danger d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $customer->name }}</strong> ({{ $customer->customer_id }})<br>
                            <small>Expires: {{ $customer->contract_end_date->format('M d, Y') }}</small>
                        </div>
                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                            Renew
                        </a>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">No contract alerts</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Maintenance -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Maintenance</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Service Type</th>
                                <th>Performed By</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentMaintenance as $maintenance)
                            <tr>
                                <td>{{ $maintenance->maintenance_date->format('M d, Y') }}</td>
                                <td>{{ $maintenance->customer->name }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $maintenance->service_type)) }}</td>
                                <td>{{ $maintenance->performed_by }}</td>
                                <td>{{ Str::limit($maintenance->notes, 50) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection