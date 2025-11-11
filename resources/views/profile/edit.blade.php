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

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <!-- Profile Information Card -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient-primary text-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-semibold">
                            <i class="fas fa-user-edit me-2"></i>Profile Information
                        </h5>
                        <div class="badge bg-white-20">
                            <i class="fas fa-user-circle me-1"></i>{{ ucfirst($user->role) }}
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
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
                        <div class="mb-4 p-3 bg-light rounded">
                            <label class="form-label fw-semibold mb-2">Account Role</label>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ ucfirst($user->role) }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Contact administrator for role changes
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Password Change Section -->
                        <div class="mb-4">
                            <h5 class="mb-3 fw-semibold text-dark border-bottom pb-2">
                                <i class="fas fa-lock me-2 text-primary"></i>Change Password
                            </h5>
                            <p class="text-muted mb-3">Leave password fields blank if you don't want to change your password.</p>

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
                                               oninput="GreenHomeApp.checkPasswordStrength(this.value, 'passwordStrengthBar', 'passwordStrengthText')">
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
                                               oninput="GreenHomeApp.checkPasswordMatch('new_password', 'new_password_confirmation', 'passwordMatchText')">
                                        <button type="button" class="input-group-text toggle-password" data-target="new_password_confirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted" id="passwordMatchText"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="button" class="btn btn-outline-warning" onclick="GreenHomeApp.resetForm('profileForm')">
                                    <i class="fas fa-undo me-2"></i>Reset Form
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success" id="updateProfileButton">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Status & Danger Zone -->
            <div class="row">
                <!-- Account Status -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-lg h-100">
                        <div class="card-header bg-gradient-success text-white py-3 border-0">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-user-check me-2"></i>Account Status
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
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
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Member Since</span>
                                    <span class="fw-semibold text-dark">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Last Updated</span>
                                    <span class="fw-semibold text-dark">{{ $user->updated_at->format('M d, Y') }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Account Role</span>
                                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-lg h-100 border-danger">
                        <div class="card-header bg-gradient-danger text-white py-3 border-0">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                            </h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="flex-grow-1">
                                <div class="text-center mb-3">
                                    <i class="fas fa-trash-alt fa-2x text-danger mb-2"></i>
                                    <p class="text-muted mb-3">
                                        Once you delete your account, there is no going back. All your data will be permanently removed from our systems.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    <i class="fas fa-trash me-2"></i>Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-danger text-white py-3 border-0">
                <h5 class="modal-title fw-semibold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="bg-danger rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fas fa-trash"></i>
                    </div>
                    <h5 class="fw-bold text-danger mb-2">Are you absolutely sure?</h5>
                    <p class="text-muted mb-3">This action cannot be undone. This will permanently delete your account and remove all your data from our servers.</p>
                </div>

                <div class="alert alert-warning border-0">
                    <div class="d-flex">
                        <i class="fas fa-warning text-warning me-3 fa-lg mt-1"></i>
                        <div>
                            <h6 class="alert-heading mb-1 fw-bold">Warning</h6>
                            <p class="mb-0 small">All your customer data, maintenance records, and account information will be permanently lost.</p>
                        </div>
                    </div>
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
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Profile edit page specific initialization
document.addEventListener('DOMContentLoaded', function() {
    // Initialize form validation
    const profileForm = document.getElementById('profileForm');
    const updateProfileButton = document.getElementById('updateProfileButton');

    if (profileForm && updateProfileButton) {
        profileForm.addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('new_password_confirmation').value;
            const currentPassword = document.getElementById('current_password').value;

            // If user is trying to change password
            if (newPassword || confirmPassword) {
                if (!currentPassword) {
                    e.preventDefault();
                    GreenHomeApp.showError('Please enter your current password to change your password');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    GreenHomeApp.showError('New passwords do not match');
                    return;
                }
            }

            // Show loading state
            updateProfileButton.classList.add('btn-loading');
            updateProfileButton.disabled = true;
        });
    }

    // Auto-focus on name field
    const nameField = document.getElementById('name');
    if (nameField) {
        setTimeout(() => {
            nameField.focus();
        }, 100);
    }
});
</script>
@endsection
