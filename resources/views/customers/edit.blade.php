@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Customer
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('customers.update', $customer) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Customer ID (Read-only) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Customer ID</label>
                            <input type="text" class="form-control" value="{{ $customer->customer_id }}" readonly>
                        </div>

                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                   id="phone_number" name="phone_number" value="{{ old('phone_number', $customer->phone_number) }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" value="{{ old('address', $customer->address) }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Google Map Link -->
                        <div class="col-md-12 mb-3">
                            <label for="google_map_link" class="form-label">Google Map Link</label>
                            <input type="url" class="form-control @error('google_map_link') is-invalid @enderror" 
                                   id="google_map_link" name="google_map_link" 
                                   value="{{ old('google_map_link', $customer->google_map_link) }}" 
                                   placeholder="https://maps.google.com/...">
                            @error('google_map_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Service Name -->
                        <div class="col-md-6 mb-3">
                            <label for="service_name" class="form-label">Service Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('service_name') is-invalid @enderror" 
                                   id="service_name" name="service_name" 
                                   value="{{ old('service_name', $customer->service_name) }}" required>
                            @error('service_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Service Price -->
                        <div class="col-md-6 mb-3">
                            <label for="service_price" class="form-label">Service Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('service_price') is-invalid @enderror" 
                                   id="service_price" name="service_price" 
                                   value="{{ old('service_price', $customer->service_price) }}" required>
                            @error('service_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Service Type -->
                        <div class="col-md-12 mb-3">
                            <label for="service_type" class="form-label">Service Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('service_type') is-invalid @enderror" 
                                    id="service_type" name="service_type" required>
                                <option value="">Select Service Type</option>
                                <option value="baiting_system_complete" {{ old('service_type', $customer->service_type) == 'baiting_system_complete' ? 'selected' : '' }}>
                                    Baiting System Complete (Maintenance every 3 months)
                                </option>
                                <option value="baiting_system_not_complete" {{ old('service_type', $customer->service_type) == 'baiting_system_not_complete' ? 'selected' : '' }}>
                                    Baiting System Not Complete (Maintenance every 3 months)
                                </option>
                                <option value="host_system" {{ old('service_type', $customer->service_type) == 'host_system' ? 'selected' : '' }}>
                                    Host System (Maintenance every 6 months)
                                </option>
                            </select>
                            @error('service_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contract Start Date -->
                        <div class="col-md-6 mb-3">
                            <label for="contract_start_date" class="form-label">Contract Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('contract_start_date') is-invalid @enderror" 
                                   id="contract_start_date" name="contract_start_date" 
                                   value="{{ old('contract_start_date', $customer->contract_start_date->format('Y-m-d')) }}" required>
                            @error('contract_start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contract End Date -->
                        <div class="col-md-6 mb-3">
                            <label for="contract_end_date" class="form-label">Contract End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('contract_end_date') is-invalid @enderror" 
                                   id="contract_end_date" name="contract_end_date" 
                                   value="{{ old('contract_end_date', $customer->contract_end_date->format('Y-m-d')) }}" required>
                            @error('contract_end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="pending" {{ old('status', $customer->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="ended" {{ old('status', $customer->status) == 'ended' ? 'selected' : '' }}>Ended</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Comments -->
                        <div class="col-md-12 mb-3">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" 
                                      id="comments" name="comments" rows="3">{{ old('comments', $customer->comments) }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Customers
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Update Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection