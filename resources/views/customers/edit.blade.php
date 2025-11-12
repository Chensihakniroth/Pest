@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <h2 class="h3 mb-1 text-dark fw-bold">Edit Customer</h2>
            <p class="text-muted mb-0">Update customer information and service details</p>
        </div>
        <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Customer
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- Customer Edit Card -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-warning text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-edit me-2"></i>Edit Customer - {{ $customer->name }}
                    </h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Please correct the following errors:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('customers.update', $customer) }}" id="customerForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Customer Information -->
                            <div class="col-lg-6">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">
                                    <i class="fas fa-user me-2"></i>Customer Information
                                </h6>

                                <!-- Customer ID (Read-only) -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Customer ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-id-card text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 bg-light"
                                               value="{{ $customer->customer_id }}" readonly>
                                    </div>
                                    <small class="text-muted">Customer ID cannot be changed</small>
                                </div>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name', $customer->name) }}"
                                               placeholder="Enter customer name" required>
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 @error('phone_number') is-invalid @enderror"
                                               id="phone_number" name="phone_number" value="{{ old('phone_number', $customer->phone_number) }}"
                                               placeholder="Enter phone number" required>
                                    </div>
                                    @error('phone_number')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                        </span>
                                        <textarea class="form-control border-start-0 @error('address') is-invalid @enderror"
                                                  id="address" name="address" rows="3"
                                                  placeholder="Enter complete address" required>{{ old('address', $customer->address) }}</textarea>
                                    </div>
                                    @error('address')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Google Map Link -->
                                <div class="mb-3">
                                    <label for="google_map_link" class="form-label fw-semibold">Google Map Link</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-map text-muted"></i>
                                        </span>
                                        <input type="url" class="form-control border-start-0 @error('google_map_link') is-invalid @enderror"
                                               id="google_map_link" name="google_map_link"
                                               value="{{ old('google_map_link', $customer->google_map_link) }}"
                                               placeholder="https://maps.google.com/...">
                                    </div>
                                    @error('google_map_link')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Optional: Link to customer location on Google Maps</small>
                                </div>
                            </div>

                            <!-- Service Information -->
                            <div class="col-lg-6">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">
                                    <i class="fas fa-cogs me-2"></i>Service Information
                                </h6>

                                <!-- Service Name -->
                                <div class="mb-3">
                                    <label for="service_name" class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-tools text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 @error('service_name') is-invalid @enderror"
                                               id="service_name" name="service_name"
                                               value="{{ old('service_name', $customer->service_name) }}"
                                               placeholder="Enter service name" required>
                                    </div>
                                    @error('service_name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Service Price -->
                                <div class="mb-3">
                                    <label for="service_price" class="form-label fw-semibold">Service Price ($) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-dollar-sign text-muted"></i>
                                        </span>
                                        <input type="number" step="0.01" class="form-control border-start-0 @error('service_price') is-invalid @enderror"
                                               id="service_price" name="service_price"
                                               value="{{ old('service_price', $customer->service_price) }}" required>
                                    </div>
                                    @error('service_price')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Service Type -->
<div class="mb-3">
    <label for="service_type" class="form-label fw-semibold">Service Type <span class="text-danger">*</span></label>
    <div class="input-group">
        <span class="input-group-text bg-light border-end-0">
            <i class="fas fa-list text-muted"></i>
        </span>
        <select class="form-control border-start-0 @error('service_type') is-invalid @enderror"
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
            <option value="drill_injection" {{ old('service_type', $customer->service_type) == 'drill_injection' ? 'selected' : '' }}>
                Drill and Injection (Maintenance every 6 months)
            </option>
        </select>
    </div>
    @error('service_type')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

                                <!-- Contract Dates -->
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2 mt-4">
                                    <i class="fas fa-calendar me-2"></i>Contract Dates
                                </h6>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="contract_start_date" class="form-label fw-semibold">Contract Start <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-calendar-plus text-muted"></i>
                                            </span>
                                            <input type="date" class="form-control border-start-0 @error('contract_start_date') is-invalid @enderror"
                                                   id="contract_start_date" name="contract_start_date"
                                                   value="{{ old('contract_start_date', $customer->contract_start_date->format('Y-m-d')) }}" required>
                                        </div>
                                        @error('contract_start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="contract_end_date" class="form-label fw-semibold">Contract End <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-calendar-minus text-muted"></i>
                                            </span>
                                            <input type="date" class="form-control border-start-0 @error('contract_end_date') is-invalid @enderror"
                                                   id="contract_end_date" name="contract_end_date"
                                                   value="{{ old('contract_end_date', $customer->contract_end_date->format('Y-m-d')) }}" required>
                                        </div>
                                        @error('contract_end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-info-circle text-muted"></i>
                                        </span>
                                        <select class="form-control border-start-0 @error('status') is-invalid @enderror"
                                                id="status" name="status" required>
                                            <option value="active" {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="pending" {{ old('status', $customer->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <strong>Active:</strong> Full access to maintenance features |
                                        <strong>Pending:</strong> Account on hold, maintenance features disabled
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">
                                    <i class="fas fa-comments me-2"></i>Additional Information
                                </h6>
                                <div class="mb-3">
                                    <label for="comments" class="form-label fw-semibold">Comments & Notes</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 align-items-start pt-3">
                                            <i class="fas fa-sticky-note text-muted"></i>
                                        </span>
                                        <textarea class="form-control border-start-0 @error('comments') is-invalid @enderror"
                                                  id="comments" name="comments" rows="4"
                                                  placeholder="Any additional comments or notes about this customer...">{{ old('comments', $customer->comments) }}</textarea>
                                    </div>
                                    @error('comments')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <a href="{{ route('customers.index') }}" class="btn btn-outline-dark">
                                    <i class="fas fa-list me-2"></i>Back to List
                                </a>
                            </div>
                            <button type="submit" class="btn btn-success" id="updateCustomerButton">
                                <i class="fas fa-save me-2"></i>Update Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card border-0 shadow-lg mt-4">
                <div class="card-header bg-info text-white py-3 border-0">
                    <h6 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-eye me-2"></i>View Customer
                            </a>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-warning w-100" onclick="GreenHome.resetForm('customerForm')">
                                <i class="fas fa-undo me-2"></i>Reset Form
                            </button>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline w-100"
                                  onsubmit="return confirm('Are you sure you want to delete {{ $customer->name }}? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-trash me-2"></i>Delete Customer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Customer edit page specific initialization
document.addEventListener('DOMContentLoaded', function() {
    // Initialize form validation with date validation
    initFormValidation('customerForm', {
        submitButtonId: 'updateCustomerButton',
        validateDates: true
    });
});
</script>
@endsection
