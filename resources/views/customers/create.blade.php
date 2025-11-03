<!-- resources/views/customers/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Add New Customer</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Customer Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Phone Number *</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                            @error('phone_number') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address *</label>
                        <textarea class="form-control" id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                        @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="google_map_link" class="form-label">Google Map Link</label>
                        <input type="url" class="form-control" id="google_map_link" name="google_map_link" value="{{ old('google_map_link') }}">
                        @error('google_map_link') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="service_name" class="form-label">Service Name *</label>
                            <input type="text" class="form-control" id="service_name" name="service_name" value="{{ old('service_name') }}" required>
                            @error('service_name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="service_price" class="form-label">Service Price *</label>
                            <input type="number" step="0.01" class="form-control" id="service_price" name="service_price" value="{{ old('service_price') }}" required>
                            @error('service_price') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="service_type" class="form-label">Service Type *</label>
                        <select class="form-control" id="service_type" name="service_type" required>
                            <option value="">Select Service Type</option>
                            <option value="baiting_system_complete" {{ old('service_type') == 'baiting_system_complete' ? 'selected' : '' }}>Baiting System Complete</option>
                            <option value="baiting_system_not_complete" {{ old('service_type') == 'baiting_system_not_complete' ? 'selected' : '' }}>Baiting System Not Complete</option>
                            <option value="host_system" {{ old('service_type') == 'host_system' ? 'selected' : '' }}>Host System</option>
                        </select>
                        @error('service_type') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contract_start_date" class="form-label">Contract Start Date *</label>
                            <input type="date" class="form-control" id="contract_start_date" name="contract_start_date" value="{{ old('contract_start_date', date('Y-m-d')) }}" required>
                            @error('contract_start_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="contract_end_date" class="form-label">Contract End Date *</label>
                            <input type="date" class="form-control" id="contract_end_date" name="contract_end_date" value="{{ old('contract_end_date', date('Y-m-d', strtotime('+1 year'))) }}" required>
                            @error('contract_end_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="comments" class="form-label">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3">{{ old('comments') }}</textarea>
                        @error('comments') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Add Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection