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
        <form method="GET" action="{{ route('customers.index') }}">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, customer ID, or phone number..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Customers Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Service Type</th>
                        <th>Contract Start</th>
                        <th>Contract End</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td><strong>{{ $customer->customer_id }}</strong></td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone_number }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $customer->service_type)) }}</td>
                        <td>{{ $customer->contract_start_date->format('M d, Y') }}</td>
                        <td class="{{ $customer->isContractExpiring() ? 'text-danger fw-bold' : '' }}">
                            {{ $customer->contract_end_date->format('M d, Y') }}
                        </td>
                        <td>
                            <span class="badge bg-{{ $customer->status == 'active' ? 'success' : ($customer->status == 'expired' ? 'danger' : 'warning') }}">
                                {{ ucfirst($customer->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection