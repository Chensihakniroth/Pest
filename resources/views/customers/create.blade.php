@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Modern Header matching your profile page -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="dashboard-title">Add New Customer</h1>
                <p class="dashboard-subtitle">Create a new customer profile and service agreement</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('customers.index') }}" class="btn-back-dashboard">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Customers</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column - Main Form -->
        <div class="col-lg-8">
            <!-- Customer Information Card -->
            <div class="section-card glass-morphism">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-user-plus"></i>
                        <span>Create New Customer</span>
                    </div>
                    <div class="section-info">
                        <span class="status-badge active">Active Form</span>
                    </div>
                </div>

                <div class="section-content">
                    @if ($errors->any())
                        <div class="alert-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Please correct the following errors:</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert-success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('customers.store') }}" method="POST" id="customerForm">
                        @csrf

                        <!-- Customer Information Section -->
                        <div class="form-grid">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i>
                                    Customer Name
                                </label>
                                <div class="input-container">
                                    <input type="text"
                                           class="modern-input @error('name') error @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           placeholder="Enter customer full name">
                                    <div class="input-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                @error('name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number Field -->
                            <div class="form-group">
                                <label for="phone_number" class="form-label">
                                    <i class="fas fa-phone"></i>
                                    Phone Number
                                </label>
                                <div class="input-container">
                                    <input type="text"
                                           class="modern-input @error('phone_number') error @enderror"
                                           id="phone_number"
                                           name="phone_number"
                                           value="{{ old('phone_number') }}"
                                           required
                                           placeholder="Enter phone number">
                                    <div class="input-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                                @error('phone_number')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address Field -->
                        <div class="form-group full-width">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Address
                            </label>
                            <div class="input-container">
                                <textarea class="modern-input @error('address') error @enderror"
                                          id="address"
                                          name="address"
                                          rows="3"
                                          required
                                          placeholder="Enter complete address">{{ old('address') }}</textarea>
                                <div class="input-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </div>
                            @error('address')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Google Map Link -->
                        <div class="form-group full-width">
                            <label for="google_map_link" class="form-label">
                                <i class="fas fa-map"> </i>
                                Google Map Link
                            </label>
                            <div class="input-container">
                                <input type="url"
                                       class="modern-input @error('google_map_link') error @enderror"
                                       id="google_map_link"
                                       name="google_map_link"
                                       value="{{ old('google_map_link') }}"
                                       placeholder="https://maps.google.com/...">
                                <div class="input-icon">
                                    <i class="fas fa-map"></i>
                                </div>
                            </div>
                            @error('google_map_link')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">Optional: Link to customer location on Google Maps</div>
                        </div>

                        <!-- Service Information Section -->
                        <div class="section-divider">
                            <div class="divider-content">
                                <i class="fas fa-cogs"></i>
                                <span>Service Information</span>
                            </div>
                        </div>

                        <div class="form-grid">
                            <!-- Service Name -->
                            <div class="form-group">
                                <label for="service_name" class="form-label">
                                    <i class="fas fa-tools"></i>
                                    Service Name
                                </label>
                                <div class="input-container">
                                    <input type="text"
                                           class="modern-input @error('service_name') error @enderror"
                                           id="service_name"
                                           name="service_name"
                                           value="{{ old('service_name') }}"
                                           required
                                           placeholder="Enter service name">
                                    <div class="input-icon">
                                        <i class="fas fa-tools"></i>
                                    </div>
                                </div>
                                @error('service_name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Service Price -->
                            <div class="form-group">
                                <label for="service_price" class="form-label">
                                    <i class="fas fa-dollar-sign"></i>
                                    Service Price
                                </label>
                                <div class="input-container">
                                    <input type="number"
                                           step="0.01"
                                           class="modern-input @error('service_price') error @enderror"
                                           id="service_price"
                                           name="service_price"
                                           value="{{ old('service_price') }}"
                                           required
                                           placeholder="0.00">
                                    <div class="input-icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                </div>
                                @error('service_price')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Service Type -->
                        <div class="form-group full-width">
                            <label for="service_type" class="form-label">
                                <i class="fas fa-list"></i>
                                Service Type
                            </label>
                            <div class="input-container">
                                <select class="modern-input @error('service_type') error @enderror"
                                        id="service_type"
                                        name="service_type"
                                        required>
                                    <option value="">Select Service Type</option>
                                    <option value="baiting_system_complete" {{ old('service_type') == 'baiting_system_complete' ? 'selected' : '' }}>
                                        Baiting System Complete (3 months maintenance)
                                    </option>
                                    <option value="baiting_system_not_complete" {{ old('service_type') == 'baiting_system_not_complete' ? 'selected' : '' }}>
                                        Baiting System Not Complete (3 months maintenance)
                                    </option>
                                    <option value="host_system" {{ old('service_type') == 'host_system' ? 'selected' : '' }}>
                                        Host System (6 months maintenance)
                                    </option>
                                    <option value="drill_injection" {{ old('service_type') == 'drill_injection' ? 'selected' : '' }}>
                                        Drill and Injection (6 months maintenance)
                                    </option>
                                </select>
                                <div class="input-icon">
                                    <i class="fas fa-list"></i>
                                </div>
                            </div>
                            @error('service_type')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contract Information Section -->
                        <div class="section-divider">
                            <div class="divider-content">
                                <i class="fas fa-file-contract"></i>
                                <span>Contract Information</span>
                            </div>
                        </div>

                        <div class="form-grid">
                            <!-- Contract Start Date -->
                            <div class="form-group">
                                <label for="contract_start_date" class="form-label">
                                    <i class="fas fa-calendar-plus"></i>
                                    Contract Start
                                </label>
                                <div class="input-container">
                                    <input type="date"
                                           class="modern-input @error('contract_start_date') error @enderror"
                                           id="contract_start_date"
                                           name="contract_start_date"
                                           value="{{ old('contract_start_date', date('Y-m-d')) }}"
                                           required>
                                    <div class="input-icon">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                </div>
                                @error('contract_start_date')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contract End Date -->
                            <div class="form-group">
                                <label for="contract_end_date" class="form-label">
                                    <i class="fas fa-calendar-minus"></i>
                                    Contract End
                                </label>
                                <div class="input-container">
                                    <input type="date"
                                           class="modern-input @error('contract_end_date') error @enderror"
                                           id="contract_end_date"
                                           name="contract_end_date"
                                           value="{{ old('contract_end_date', date('Y-m-d', strtotime('+1 year'))) }}"
                                           required>
                                    <div class="input-icon">
                                        <i class="fas fa-calendar-minus"></i>
                                    </div>
                                </div>
                                @error('contract_end_date')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group full-width">
                            <label for="status" class="form-label">
                                <i class="fas fa-info-circle"></i>
                                Status
                            </label>
                            <div class="input-container">
                                <select class="modern-input @error('status') error @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                                <div class="input-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </div>
                            @error('status')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <div class="form-hint">
                                <span class="status-active"><i class="fas fa-check-circle"></i> Active:</span> Full access to maintenance features
                                <span class="status-pending"><i class="fas fa-pause-circle"></i> Pending:</span> Account on hold, maintenance features disabled
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="section-divider">
                            <div class="divider-content">
                                <i class="fas fa-comments"></i>
                                <span>Additional Information</span>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div class="form-group full-width">
                            <label for="comments" class="form-label">
                                <i class="fas fa-sticky-note"></i>
                                Comments & Notes
                            </label>
                            <div class="input-container">
                                <textarea class="modern-input @error('comments') error @enderror"
                                          id="comments"
                                          name="comments"
                                          rows="4"
                                          placeholder="Any additional comments or notes about this customer...">{{ old('comments') }}</textarea>
                                <div class="input-icon">
                                    <i class="fas fa-sticky-note"></i>
                                </div>
                            </div>
                            @error('comments')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                            <button type="button" class="btn btn-warning" onclick="resetForm()">
                                <i class="fas fa-undo"></i>
                                Reset Form
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save"></i>
                                Create Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Quick Tips & Information -->
        <div class="col-lg-4">
            <!-- Quick Actions Card -->
            <div class="section-card glass-morphism">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-bolt"></i>
                        <span>Quick Actions</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="action-grid">
                        <a href="{{ route('customers.index') }}" class="action-card">
                            <div class="action-icon customers">
                                <i class="fas fa-users"></i>
                            </div>
                            <span>View All Customers</span>
                        </a>
                        <button type="button" class="action-card" onclick="resetForm()">
                            <div class="action-icon reset">
                                <i class="fas fa-undo"></i>
                            </div>
                            <span>Reset Form</span>
                        </button>
                        <a href="{{ route('dashboard') }}" class="action-card">
                            <div class="action-icon dashboard">
                                <i class="fas fa-home"></i>
                            </div>
                            <span>Back to Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>

<style>
/* Customer Create Specific Styles - Matching Profile Page */
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Modern Header matching your profile page */
.dashboard-header {
    margin-bottom: 1.5rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 2rem;
}

.header-text {
    flex: 1;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--gh-text);
    margin: 0 0 0.5rem 0;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.dashboard-subtitle {
    color: var(--gh-text-light);
    margin: 0;
    font-size: 1rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Back to Dashboard Button */
.btn-back-dashboard {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    backdrop-filter: blur(10px);
}

.btn-back-dashboard:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    background: linear-gradient(135deg, var(--gh-primary-dark), var(--gh-primary));
    color: white;
}

/* Section Cards matching your profile design */
.section-card {
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}

.section-card:nth-child(1) { animation-delay: 0.1s; }
.section-card:nth-child(2) { animation-delay: 0.2s; }
.section-card:nth-child(3) { animation-delay: 0.3s; }

.section-header {
    padding: 1.25rem 1.5rem;
    background: var(--gh-glass);
    border-bottom: 1px solid var(--gh-glass-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--gh-text);
}

.section-title i {
    font-size: 1rem;
    color: var(--gh-primary);
}

.section-info {
    font-size: 0.875rem;
    color: var(--gh-text-light);
}

.section-content {
    background: var(--gh-glass);
    padding: 1.5rem;
}

/* Form Styles matching profile page */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gh-text);
    margin-bottom: 0.25rem;
}

.form-label i {
    color: var(--gh-text-light);
    width: 16px;
}

.input-container {
    position: relative;
    display: flex;
    align-items: center;
}

.modern-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 1.5px solid var(--gh-glass-border);
    border-radius: 10px;
    background: var(--gh-glass);
    color: var(--gh-text);
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.modern-input:focus {
    outline: none;
    border-color: var(--gh-primary);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.modern-input.error {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.input-icon {
    position: absolute;
    left: 1rem;
    color: var(--gh-text-light);
    z-index: 2;
}

.error-message {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-hint {
    font-size: 0.75rem;
    color: var(--gh-text-light);
    margin-top: 0.5rem;
    line-height: 1.4;
}

.status-active, .status-pending {
    font-weight: 600;
    margin-right: 1rem;
}

.status-active {
    color: #10b981;
}

.status-pending {
    color: #6b7280;
}

/* Alerts matching profile page */
.alert-success, .alert-error {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border: 1px solid;
    position: relative;
}

.alert-success {
    background: linear-gradient(135deg, #d1e7dd, #c3e6cb);
    border-color: #a3cfbb;
    color: #0f5132;
}

.alert-error {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    border-color: #f1aeb5;
    color: #721c24;
}

.alert-close {
    position: absolute;
    right: 0.75rem;
    top: 0.75rem;
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.alert-close:hover {
    opacity: 1;
}

/* Section Divider */
.section-divider {
    position: relative;
    text-align: center;
    margin: 2rem 0 1.5rem;
}

.section-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--gh-glass-border);
    z-index: 1;
}

.divider-content {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--gh-glass);
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    border: 1px solid var(--gh-glass-border);
    color: var(--gh-text);
    font-weight: 600;
    font-size: 0.875rem;
    z-index: 2;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--gh-glass-border);
}

/* Buttons matching profile page */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: 1.5px solid;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-secondary {
    background: var(--gh-glass);
    border-color: var(--gh-glass-border);
    color: var(--gh-text);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-1px);
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
    background: linear-gradient(135deg, #d97706, #b45309);
}

.btn-primary {
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    background: linear-gradient(135deg, var(--gh-primary-dark), var(--gh-primary));
}

/* Quick Actions */
.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 1rem;
}

.action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 1.5rem 1rem;
    background: var(--gh-glass);
    border: 1.5px solid var(--gh-glass-border);
    border-radius: 12px;
    text-decoration: none;
    color: var(--gh-text);
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
    text-align: center;
}

.action-card:hover {
    transform: translateY(-2px);
    border-color: var(--gh-primary);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.action-icon.dashboard {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
}

.action-icon.customers {
    background: linear-gradient(135deg, #10b981, #059669);
}

.action-icon.reset {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.status-badge.active {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

/* Tips Card */
.tips-card {
    margin-top: 1.5rem;
}

.tips-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tip-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border: 1px solid var(--gh-glass-border);
}

.tip-item span {
    font-size: 0.875rem;
    color: var(--gh-text);
}

/* Service Types */
.service-types {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.service-type-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    border: 1px solid var(--gh-glass-border);
}

.service-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.service-icon.baiting {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.service-icon.host {
    background: linear-gradient(135deg, #10b981, #059669);
}

.service-icon.drill {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.service-info {
    flex: 1;
}

.service-info strong {
    display: block;
    font-size: 0.875rem;
    color: var(--gh-text);
    margin-bottom: 0.25rem;
}

.service-info small {
    color: var(--gh-text-light);
    font-size: 0.75rem;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .header-actions {
        width: 100%;
        justify-content: flex-start;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 0 0.5rem;
    }

    .section-content {
        padding: 1rem;
    }

    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .action-grid {
        grid-template-columns: 1fr;
    }
}

/* Dark mode adjustments */
.dark .alert-success {
    background: linear-gradient(135deg, rgba(21, 128, 61, 0.2), rgba(22, 163, 74, 0.1));
    border-color: rgba(34, 197, 94, 0.3);
    color: #86efac;
}

.dark .alert-error {
    background: linear-gradient(135deg, rgba(185, 28, 28, 0.2), rgba(220, 38, 38, 0.1));
    border-color: rgba(248, 113, 113, 0.3);
    color: #fca5a5;
}

.dark .tip-item,
.dark .service-type-item {
    background: rgba(255, 255, 255, 0.02);
    border-color: rgba(255, 255, 255, 0.1);
}

.dark .action-card {
    background: rgba(255, 255, 255, 0.02);
    border-color: rgba(255, 255, 255, 0.1);
}

.dark .action-card:hover {
    background: rgba(255, 255, 255, 0.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission enhancement
    const customerForm = document.getElementById('customerForm');
    const submitBtn = document.getElementById('submitBtn');

    if (customerForm && submitBtn) {
        customerForm.addEventListener('submit', function(e) {
            let isValid = true;

            // Basic validation
            const requiredFields = customerForm.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message';
                        errorDiv.textContent = 'This field is required';
                        field.parentElement.parentElement.appendChild(errorDiv);
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
                showFormError('Please fill in all required fields.');
            } else {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
                submitBtn.disabled = true;
            }
        });
    }

    // Auto-focus first field
    const firstField = document.querySelector('#name');
    if (firstField) {
        firstField.focus();
    }

    // Add loading animation to cards
    const cards = document.querySelectorAll('.section-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });

    // Date validation
    const startDate = document.getElementById('contract_start_date');
    const endDate = document.getElementById('contract_end_date');

    if (startDate && endDate) {
        startDate.addEventListener('change', validateDates);
        endDate.addEventListener('change', validateDates);
    }

    function validateDates() {
        if (startDate.value && endDate.value) {
            if (new Date(startDate.value) >= new Date(endDate.value)) {
                endDate.classList.add('error');
                if (!endDate.nextElementSibling || !endDate.nextElementSibling.classList.contains('error-message')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.textContent = 'End date must be after start date';
                    endDate.parentElement.parentElement.appendChild(errorDiv);
                }
            } else {
                endDate.classList.remove('error');
                const errorMsg = endDate.parentElement.parentElement.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            }
        }
    }
});

// Reset form function
function resetForm() {
    const form = document.getElementById('customerForm');
    form.reset();

    // Clear all error states
    const errorFields = form.querySelectorAll('.error');
    errorFields.forEach(field => field.classList.remove('error'));

    const errorMessages = form.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.remove());

    // Reset dates to default
    document.getElementById('contract_start_date').value = '{{ date('Y-m-d') }}';
    document.getElementById('contract_end_date').value = '{{ date('Y-m-d', strtotime('+1 year')) }}';

    // Show success message
    showResetSuccess();
}

function showResetSuccess() {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert-success, .alert-error');
    existingAlerts.forEach(alert => alert.remove());

    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert-success';
    alertDiv.innerHTML = `
        <i class="fas fa-check-circle"></i>
        Form has been reset to default values.
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    const form = document.getElementById('customerForm');
    form.insertBefore(alertDiv, form.firstChild);

    // Auto-remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.remove();
        }
    }, 3000);
}

function showFormError(message) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert-error');
    existingAlerts.forEach(alert => alert.remove());

    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert-error';
    alertDiv.innerHTML = `
        <i class="fas fa-exclamation-triangle"></i>
        <div>${message}</div>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    const form = document.getElementById('customerForm');
    form.insertBefore(alertDiv, form.firstChild);

    // Scroll to alert
    alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// Add smooth scrolling for better UX
function smoothScrollToElement(element) {
    element.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}
</script>
@endsection
