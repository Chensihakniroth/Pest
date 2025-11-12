@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Enhanced Header with iPhone-style Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 dark:text-gray-100 fw-bold">Profile Settings</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-0 small">Manage your account information and security</p>
        </div>
        <!-- iPhone-style Back Button -->
        <a href="{{ route('dashboard') }}" class="btn-back-dashboard"
           style="display: inline-flex;
                  align-items: center;
                  gap: 0.5rem;
                  background: linear-gradient(135deg, #2d3748, #1a1d2e);
                  color: #ffffff;
                  border: 1.5px solid #e5e7eb;
                  border-radius: 14px;
                  padding: 0.75rem 1.5rem;
                  text-decoration: none;
                  font-weight: 600;
                  font-size: 0.875rem;
                  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                  backdrop-filter: blur(10px);">
            <i class="fas fa-arrow-left" style="font-size: 0.8rem;"></i>
            <span>Back to Dashboard</span>
        </a>
    </div>

    <div class="row g-4">
        <!-- Left Column - Profile Information & Actions -->
        <div class="col-lg-8">
            <!-- Profile Information Card -->
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <h6 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                        <i class="fas fa-user-circle me-2 text-green-500"></i>Profile Information
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                        @csrf
                        @method('PATCH')

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show dark:bg-green-900/50 dark:border-green-800 dark:text-green-200" role="alert"
                                 style="border-radius: 12px; border: 1px solid #d1e7dd;
                                        background: linear-gradient(135deg, #d1e7dd, #c3e6cb);">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show dark:bg-red-900/50 dark:border-red-800 dark:text-red-200" role="alert"
                                 style="border-radius: 12px; border: 1px solid #f1aeb5;
                                        background: linear-gradient(135deg, #f8d7da, #f5c6cb);">
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

                        <div class="row g-3">
                            <!-- Name Field -->
                            <div class="col-md-6">
                                <label for="name" class="form-label small fw-semibold text-gray-800 dark:text-gray-200">
                                    <i class="fas fa-user me-1 text-gray-500 dark:text-gray-400"></i>Full Name
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white dark:bg-gray-700 border-end-0 border-gray-300 dark:border-gray-600 ps-3">
                                        <i class="fas fa-user text-gray-500 dark:text-gray-400"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control border-start-0 modern-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $user->name) }}"
                                           required
                                           autocomplete="name"
                                           placeholder="Enter your full name">
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-semibold text-gray-800 dark:text-gray-200">
                                    <i class="fas fa-envelope me-1 text-gray-500 dark:text-gray-400"></i>Email Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white dark:bg-gray-700 border-end-0 border-gray-300 dark:border-gray-600 ps-3">
                                        <i class="fas fa-envelope text-gray-500 dark:text-gray-400"></i>
                                    </span>
                                    <input type="email"
                                           class="form-control border-start-0 modern-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $user->email) }}"
                                           required
                                           autocomplete="email"
                                           placeholder="Enter your email address">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Change Section -->
                        <div class="mt-4 pt-4 border-top border-gray-200 dark:border-gray-600">
                            <h6 class="fw-semibold text-gray-800 dark:text-gray-200 mb-3">
                                <i class="fas fa-lock me-2 text-yellow-500 dark:text-yellow-400"></i>Change Password
                            </h6>
                            <p class="text-gray-600 dark:text-gray-400 small mb-4">Leave password fields blank if you don't want to change your password.</p>

                            <div class="row g-3">
                                <!-- Current Password -->
                                <div class="col-md-6">
                                    <label for="current_password" class="form-label small fw-semibold text-gray-800 dark:text-gray-200">
                                        <i class="fas fa-key me-1 text-gray-500 dark:text-gray-400"></i>Current Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white dark:bg-gray-700 border-end-0 border-gray-300 dark:border-gray-600 ps-3">
                                            <i class="fas fa-key text-gray-500 dark:text-gray-400"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control border-start-0 modern-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 @error('current_password') is-invalid @enderror"
                                               id="current_password"
                                               name="current_password"
                                               autocomplete="current-password"
                                               placeholder="Enter current password">
                                    </div>
                                    @error('current_password')
                                        <div class="invalid-feedback d-block text-red-600 dark:text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="col-md-6">
                                    <label for="new_password" class="form-label small fw-semibold text-gray-800 dark:text-gray-200">
                                        <i class="fas fa-lock me-1 text-gray-500 dark:text-gray-400"></i>New Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white dark:bg-gray-700 border-end-0 border-gray-300 dark:border-gray-600 ps-3">
                                            <i class="fas fa-lock text-gray-500 dark:text-gray-400"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control border-start-0 modern-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 @error('new_password') is-invalid @enderror"
                                               id="new_password"
                                               name="new_password"
                                               autocomplete="new-password"
                                               placeholder="Enter new password">
                                    </div>
                                    @error('new_password')
                                        <div class="invalid-feedback d-block text-red-600 dark:text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm New Password -->
                                <div class="col-md-6">
                                    <label for="new_password_confirmation" class="form-label small fw-semibold text-gray-800 dark:text-gray-200">
                                        <i class="fas fa-lock me-1 text-gray-500 dark:text-gray-400"></i>Confirm New Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white dark:bg-gray-700 border-end-0 border-gray-300 dark:border-gray-600 ps-3">
                                            <i class="fas fa-lock text-gray-500 dark:text-gray-400"></i>
                                        </span>
                                        <input type="password"
                                               class="form-control border-start-0 modern-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                               id="new_password_confirmation"
                                               name="new_password_confirmation"
                                               autocomplete="new-password"
                                               placeholder="Confirm new password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-4 pt-4 border-top border-gray-200 dark:border-gray-600">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600"
                                   style="border-radius: 12px; padding: 0.75rem 1.5rem;">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn-update-profile"
                                        style="display: inline-flex; align-items: center; gap: 0.5rem;
                                               background: linear-gradient(135deg, #10b981, #059669);
                                               color: white; border: none; border-radius: 14px;
                                               padding: 0.75rem 2rem; text-decoration: none;
                                               font-weight: 600; font-size: 0.875rem;
                                               transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                                               box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
                                               backdrop-filter: blur(10px);">
                                    <i class="fas fa-save me-2"></i>
                                    <span>Update Profile</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card glass-morphism border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <h6 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                        <i class="fas fa-bolt me-2 text-yellow-500"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm w-100 dark:border-blue-600 dark:text-blue-400 dark:hover:bg-blue-600/20"
                               style="border-radius: 10px; padding: 0.75rem 1rem;">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-success btn-sm w-100 dark:border-green-600 dark:text-green-400 dark:hover:bg-green-600/20"
                               style="border-radius: 10px; padding: 0.75rem 1rem;">
                                <i class="fas fa-users me-2"></i>Customers
                            </a>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-warning btn-sm w-100 dark:border-yellow-600 dark:text-yellow-400 dark:hover:bg-yellow-600/20"
                                    onclick="document.getElementById('profileForm').reset();"
                                    style="border-radius: 10px; padding: 0.75rem 1rem;">
                                <i class="fas fa-undo me-2"></i>Reset Form
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone Card - Fixed Border Radius -->
            <div class="card glass-morphism border-0 shadow-sm danger-zone-card">
                <div class="card-header bg-transparent py-3 px-4 border-bottom danger-zone-header">
                    <h6 class="mb-0 fw-semibold text-red-600 dark:text-red-400">
                        <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                    </h6>
                </div>
                <div class="card-body p-3 danger-zone-body">
                    <p class="small text-gray-600 dark:text-gray-400 mb-3">
                        Once you delete your account, there is no going back. Please be certain.
                    </p>
                    <form action="{{ route('profile.destroy') }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 dark:border-red-600 dark:text-red-400 dark:hover:bg-red-600/20"
                                style="border-radius: 10px; padding: 0.75rem 1rem;">
                            <i class="fas fa-trash me-2"></i>Delete My Account
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Compact Account Summary -->
        <div class="col-lg-4">
            <!-- Compact Account Summary Card -->
            <div class="card glass-morphism border-0 shadow-sm" style="height: 50%;">
                <div class="card-header bg-transparent py-3 px-4 border-bottom border-gray-200 dark:border-gray-600">
                    <h6 class="mb-0 fw-semibold text-gray-800 dark:text-gray-100">
                        <i class="fas fa-id-card me-2 text-blue-500"></i>Account Summary
                    </h6>
                </div>
                <div class="card-body p-3 d-flex flex-column">
                    <!-- Compact User Info -->
                    <div class="text-center mb-3">
                        <div class="user-avatar mx-auto mb-2"
                             style="width: 50px; height: 50px;
                                    background: linear-gradient(135deg, #10b981, #059669);
                                    border-radius: 50%; display: flex; align-items: center;
                                    justify-content: center; font-size: 1.25rem; font-weight: 600; color: white;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h6 class="fw-bold text-gray-800 dark:text-gray-100 mb-1 small">{{ $user->name }}</h6>
                        <p class="text-gray-600 dark:text-gray-400 small mb-2">{{ $user->email }}</p>
                        <span class="badge bg-green-500 dark:bg-green-600 text-white small" style="border-radius: 10px;">
                            <i class="fas fa-check-circle me-1"></i>Active
                        </span>
                    </div>

                    <!-- Compact Stats -->
                    <div class="account-stats-compact mt-auto">
                        <div class="d-flex justify-content-between align-items-center py-1 border-bottom border-gray-200 dark:border-gray-600">
                            <span class="text-gray-600 dark:text-gray-400 small">Member since</span>
                            <span class="fw-semibold text-gray-800 dark:text-gray-200 small">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-1">
                            <span class="text-gray-600 dark:text-gray-400 small">Role</span>
                            <span class="fw-semibold text-gray-800 dark:text-gray-200 small">Admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty Space Below -->
            <div style="height: 50%;" class="d-flex align-items-center justify-content-center">
                <div class="text-center text-muted small">
                    <i class="fas fa-user-shield fa-2x mb-2 opacity-50"></i>
                    <p>Profile Management<br>Made by niroth</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile-specific styles that match your iPhone aesthetic */
.glass-morphism {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
}

.dark .glass-morphism {
    background: rgba(30, 30, 30, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Modern Inputs matching your design */
.modern-input {
    border-radius: 10px;
    border: 1.5px solid #e5e7eb;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    background: white;
}

.modern-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.1);
}

.dark .modern-input {
    background: #374151;
    border-color: #4b5563;
    color: #f9fafb;
}

.dark .modern-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.2);
}

/* Button hover effects */
.btn-back-dashboard:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 0.95) !important;
}

.dark .btn-back-dashboard {
    background: rgba(55, 65, 81, 0.9) !important;
    color: #d1d5db !important;
    border-color: #4b5563 !important;
}

.dark .btn-back-dashboard:hover {
    background: rgba(75, 85, 99, 0.95) !important;
}

.btn-update-profile:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    background: linear-gradient(135deg, #059669, #047857) !important;
}

/* User avatar animation */
.user-avatar {
    transition: all 0.3s ease;
}

.user-avatar:hover {
    transform: scale(1.05);
}

/* Compact account stats styling with perfect dark mode matching */
.account-stats-compact {
    background: linear-gradient(135deg, #2d3748, #1a1d2e);
    border-radius: 8px;
    padding: 0.75rem;
    backdrop-filter: blur(8px);
    border: 1px solid #1a1d2e;
}

.dark .account-stats-compact {
    background: linear-gradient(135deg, rgba(17, 24, 39, 0.8), rgba(31, 41, 55, 0.6));
    border: 1px solid rgba(55, 65, 81, 0.5);
    backdrop-filter: blur(8px);
}

/* Danger Zone Card - Perfect Border Radius for Both Modes */
.danger-zone-card {
    border: 1.5px solid #fecaca !important;
    border-radius: 12px !important;
}

.danger-zone-header {
    border-bottom: 1.5px solid #fecaca !important;
    border-radius: 12px 12px 0 0 !important;
}

.danger-zone-body {
    border-radius: 0 0 12px 12px !important;
}

/* Dark Mode Danger Zone */
.dark .danger-zone-card {
    border: 1.5px solid #991b1b !important;
    border-radius: 12px !important;
}

.dark .danger-zone-header {
    border-bottom: 1.5px solid #991b1b !important;
    border-radius: 12px 12px 0 0 !important;
}

.dark .danger-zone-body {
    border-radius: 0 0 12px 12px !important;
}

/* Responsive design */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .card-body {
        padding: 1rem !important;
    }

    .user-avatar {
        width: 40px !important;
        height: 40px !important;
        font-size: 1rem !important;
    }
}

/* Smooth animations */
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

.card {
    animation: fadeInUp 0.4s ease forwards;
}

.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password validation
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');

    function validatePasswords() {
        if (newPassword.value && confirmPassword.value) {
            if (newPassword.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
            } else {
                confirmPassword.setCustomValidity('');
            }
        }
    }

    if (newPassword && confirmPassword) {
        newPassword.addEventListener('input', validatePasswords);
        confirmPassword.addEventListener('input', validatePasswords);
    }

    // Form submission enhancement
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                submitBtn.disabled = true;
            }
        });
    }

    // Auto-focus first field
    const firstField = document.querySelector('#name');
    if (firstField) {
        firstField.focus();
    }
});
</script>
@endsection
