@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-4">
        <div>
            <h2 class="h3 mb-1 text-dark fw-bold">Profile Settings</h2>
            <p class="text-muted mb-0">Manage your account information and preferences</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Profile Information Card -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-primary text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-user-edit me-2"></i>Profile Information
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

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $user->name) }}"
                                           placeholder="Enter your full name" required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $user->email) }}"
                                           placeholder="Enter your email" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Role -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Current Role</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user-tag text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 bg-light"
                                       value="{{ ucfirst($user->role) }}" readonly>
                            </div>
                            <small class="text-muted mt-1">
                                <i class="fas fa-info-circle me-1"></i>
                                Role cannot be changed from profile settings. Contact administrator for role changes.
                            </small>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3 fw-semibold text-dark">
                            <i class="fas fa-lock me-2"></i>Change Password
                        </h5>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Current Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password"
                                       placeholder="Enter current password">
                                <button type="button" class="input-group-text toggle-password" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Required only if changing password</small>
                        </div>

                        <div class="row">
                            <!-- New Password -->
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label fw-semibold">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 @error('new_password') is-invalid @enderror"
                                           id="new_password" name="new_password"
                                           placeholder="Enter new password"
                                           oninput="checkPasswordStrength(this.value)">
                                    <button type="button" class="input-group-text toggle-password" data-target="new_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="password-strength mt-2">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar" id="passwordStrengthBar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted" id="passwordStrengthText">Password strength</small>
                                </div>
                                @error('new_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="col-md-6 mb-3">
                                <label for="new_password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0"
                                           id="new_password_confirmation" name="new_password_confirmation"
                                           placeholder="Confirm new password"
                                           oninput="checkPasswordMatch()">
                                    <button type="button" class="input-group-text toggle-password" data-target="new_password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted" id="passwordMatchText"></small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-success" id="updateProfileButton">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Account Status Card -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-success text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-user-check me-2"></i>Account Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle text-white d-flex align-items-center justify-content-center me-3"
                             style="width: 50px; height: 50px; font-size: 1.2rem;">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark">Active Account</div>
                            <small class="text-muted">Your account is active and in good standing</small>
                        </div>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span class="text-muted">Member Since</span>
                            <span class="fw-semibold">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span class="text-muted">Last Updated</span>
                            <span class="fw-semibold">{{ $user->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                            <span class="text-muted">Account Role</span>
                            <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone Card -->
            <div class="card border-0 shadow-lg border-danger">
                <div class="card-header bg-danger text-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Once you delete your account, there is no going back. All your data will be permanently removed.
                    </p>
                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash me-2"></i>Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="bg-danger rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fas fa-trash"></i>
                    </div>
                    <h5 class="fw-bold text-danger">Are you sure?</h5>
                </div>

                <p class="text-muted mb-3">This action cannot be undone. This will permanently delete your account and remove all your data from our servers.</p>

                <div class="alert alert-warning">
                    <i class="fas fa-warning me-2"></i>
                    <strong>Warning:</strong> All your customer data, maintenance records, and account information will be lost.
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Enter your password to confirm:</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-key text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0"
                                   id="password" name="password"
                                   placeholder="Your current password" required>
                            <button type="button" class="input-group-text toggle-password" data-target="password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Delete Account
                </button>
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

.toggle-password {
    cursor: pointer;
    border-left: none;
    border-radius: 0 8px 8px 0;
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
    border-left: none;
}

.toggle-password:hover {
    background-color: #e9ecef;
}

.password-strength .progress {
    background-color: #e9ecef;
    border-radius: 2px;
}

.progress-bar {
    border-radius: 2px;
    transition: all 0.3s ease;
}

.alert {
    border-radius: 10px;
    border: none;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.list-group-item {
    padding: 0.75rem 0;
}

.modal-content {
    border-radius: 12px;
    border: none;
}

.modal-header {
    border-radius: 12px 12px 0 0;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    const updateProfileButton = document.getElementById('updateProfileButton');

    // Toggle password visibility
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            const input = document.getElementById(target);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });
    });

    // Form submission handler
    profileForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        const currentPassword = document.getElementById('current_password').value;

        // If user is trying to change password
        if (newPassword || confirmPassword) {
            if (!currentPassword) {
                e.preventDefault();
                showError('Please enter your current password to change your password');
                return;
            }

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                showError('New passwords do not match');
                return;
            }
        }

        // Show loading state
        updateProfileButton.classList.add('btn-loading');
        updateProfileButton.disabled = true;
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
    }
});

// Password strength checker
function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrengthText');

    let strength = 0;
    let tips = "";

    // Check password length
    if (password.length >= 8) {
        strength += 25;
    } else {
        tips += "Make the password at least 8 characters. ";
    }

    // Check for mixed case
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) {
        strength += 25;
    } else {
        tips += "Include both lowercase and uppercase letters. ";
    }

    // Check for numbers
    if (password.match(/\d/)) {
        strength += 25;
    } else {
        tips += "Include at least one number. ";
    }

    // Check for special characters
    if (password.match(/[^a-zA-Z\d]/)) {
        strength += 25;
    } else {
        tips += "Include at least one special character. ";
    }

    // Update progress bar
    strengthBar.style.width = strength + '%';

    // Update colors and text based on strength
    if (strength < 50) {
        strengthBar.className = 'progress-bar bg-danger';
        strengthText.textContent = 'Weak password';
        strengthText.className = 'text-danger';
    } else if (strength < 75) {
        strengthBar.className = 'progress-bar bg-warning';
        strengthText.textContent = 'Medium password';
        strengthText.className = 'text-warning';
    } else {
        strengthBar.className = 'progress-bar bg-success';
        strengthText.textContent = 'Strong password';
        strengthText.className = 'text-success';
    }

    // Show tips for weak passwords
    if (strength < 75 && password.length > 0) {
        strengthText.textContent += ' - ' + tips.trim();
    }
}

// Password match checker
function checkPasswordMatch() {
    const password = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('new_password_confirmation').value;
    const matchText = document.getElementById('passwordMatchText');

    if (confirmPassword.length === 0) {
        matchText.textContent = '';
        matchText.className = 'text-muted';
    } else if (password === confirmPassword) {
        matchText.textContent = '✓ Passwords match';
        matchText.className = 'text-success';
    } else {
        matchText.textContent = '✗ Passwords do not match';
        matchText.className = 'text-danger';
    }
}
</script>
@endsection
