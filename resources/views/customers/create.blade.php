<!-- resources/views/customers/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <h2 class="h3 mb-1 text-dark fw-bold">Add New Customer</h2>
            <p class="text-muted mb-0">Create a new customer profile and service agreement</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Customers
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- Customer Creation Card -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-success text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-user-plus me-2"></i>Create New Customer
                    </h5>
                </div>
                <div class="card-body">
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

                    <form action="{{ route('customers.store') }}" method="POST" id="customerForm">
                        @csrf

                        <div class="row">
                            <!-- Customer Information -->
                            <div class="col-lg-6">
                                <h6 class="fw-semibold text-dark mb-3 border-bottom pb-2">
                                    <i class="fas fa-user me-2"></i>Customer Information
                                </h6>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}"
                                               placeholder="Enter customer full name" required>
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
                                               id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
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
                                        <span class="input-group-text bg-light border-end-0 align-items-start pt-3">
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                        </span>
                                        <textarea class="form-control border-start-0 @error('address') is-invalid @enderror"
                                                  id="address" name="address" rows="3"
                                                  placeholder="Enter complete address" required>{{ old('address') }}</textarea>
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
                                               value="{{ old('google_map_link') }}"
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
                                               id="service_name" name="service_name" value="{{ old('service_name') }}"
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
                                               id="service_price" name="service_price" value="{{ old('service_price') }}" required>
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
                                            <option value="baiting_system_complete" {{ old('service_type') == 'baiting_system_complete' ? 'selected' : '' }}>
                                                Baiting System Complete (Maintenance every 3 months)
                                            </option>
                                            <option value="baiting_system_not_complete" {{ old('service_type') == 'baiting_system_not_complete' ? 'selected' : '' }}>
                                                Baiting System Not Complete (Maintenance every 3 months)
                                            </option>
                                            <option value="host_system" {{ old('service_type') == 'host_system' ? 'selected' : '' }}>
                                                Host System (Maintenance every 6 months)
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
                                                   value="{{ old('contract_start_date', date('Y-m-d')) }}" required>
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
                                                   value="{{ old('contract_end_date', date('Y-m-d', strtotime('+1 year'))) }}" required>
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
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
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
                                                  placeholder="Any additional comments or notes about this customer...">{{ old('comments') }}</textarea>
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
                                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="button" class="btn btn-outline-warning" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>Reset Form
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success" id="createCustomerButton">
                                <i class="fas fa-save me-2"></i>Create Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Tips Card -->
            <div class="card border-0 shadow-lg mt-4">
                <div class="card-header bg-info text-white py-3 border-0">
                    <h6 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-lightbulb me-2"></i>Quick Tips
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-check text-success me-3 fa-lg"></i>
                                <div>
                                    <div class="fw-semibold">Contract Dates</div>
                                    <small class="text-muted">Set realistic start and end dates</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tools text-primary me-3 fa-lg"></i>
                                <div>
                                    <div class="fw-semibold">Service Type</div>
                                    <small class="text-muted">Choose the correct maintenance schedule</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marked-alt text-warning me-3 fa-lg"></i>
                                <div>
                                    <div class="fw-semibold">Location</div>
                                    <small class="text-muted">Add Google Maps link for easy navigation</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
}

.shadow-lg {
    box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
}

.form-control {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1);
}

.input-group-text {
    border-radius: 8px 0 0 8px;
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
    border-right: none;
}

.input-group .form-control {
    border-left: none;
    border-right: 1px solid #e0e0e0;
}

.input-group .form-control:focus {
    border-left: none;
    border-right: 1px solid #198754;
}

.input-group .form-select {
    border-left: none;
    border-right: 1px solid #e0e0e0;
}

.input-group .form-select:focus {
    border-left: none;
    border-right: 1px solid #198754;
}

.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-1px);
}

.alert {
    border-radius: 10px;
    border: none;
}

.border-bottom {
    border-color: #dee2e6 !important;
}

/* Loading animation */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-right-color: transparent;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .btn-group {
        width: 100%;
    }

    .btn-group .btn {
        flex: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerForm = document.getElementById('customerForm');
    const createCustomerButton = document.getElementById('createCustomerButton');

    // Form submission handler
    customerForm.addEventListener('submit', function(e) {
        // Basic validation
        const requiredFields = customerForm.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            showError('Please fill in all required fields');
            return;
        }

        // Contract date validation
        const startDate = new Date(document.getElementById('contract_start_date').value);
        const endDate = new Date(document.getElementById('contract_end_date').value);

        if (endDate <= startDate) {
            e.preventDefault();
            showError('Contract end date must be after start date');
            return;
        }

        // Show loading state
        createCustomerButton.classList.add('btn-loading');
        createCustomerButton.disabled = true;
    });

    // Function to show error messages
    function showError(message) {
        // Remove existing error alerts
        const existingAlerts = document.querySelectorAll('.alert-danger');
        existingAlerts.forEach(alert => alert.remove());

        // Create new error alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert after the header
        const cardBody = document.querySelector('.card-body');
        const firstChild = cardBody.firstChild;
        cardBody.insertBefore(alertDiv, firstChild);

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Real-time validation for required fields
    const requiredFields = customerForm.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
        });
    });

    // Contract date validation
    const startDateField = document.getElementById('contract_start_date');
    const endDateField = document.getElementById('contract_end_date');

    if (startDateField && endDateField) {
        startDateField.addEventListener('change', validateDates);
        endDateField.addEventListener('change', validateDates);
    }

    function validateDates() {
        const startDate = new Date(startDateField.value);
        const endDate = new Date(endDateField.value);

        if (startDateField.value && endDateField.value && endDate <= startDate) {
            endDateField.classList.add('is-invalid');
        } else {
            endDateField.classList.remove('is-invalid');
        }
    }

    // Auto-format phone number
    const phoneField = document.getElementById('phone_number');
    if (phoneField) {
        phoneField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                value = value.match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                e.target.value = !value[2] ? value[1] : '(' + value[1] + ') ' + value[2] + (value[3] ? '-' + value[3] : '');
            }
        });
    }
});

// Reset form function
function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        document.getElementById('customerForm').reset();

        // Remove validation classes
        const fields = document.querySelectorAll('.is-valid, .is-invalid');
        fields.forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
        });

        // Reset dates to default
        document.getElementById('contract_start_date').value = '{{ date('Y-m-d') }}';
        document.getElementById('contract_end_date').value = '{{ date('Y-m-d', strtotime('+1 year')) }}';
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl + S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('createCustomerButton').click();
    }

    // Escape to cancel
    if (e.key === 'Escape') {
        window.location.href = "{{ route('customers.index') }}";
    }
});
</script>
@endsection
