@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center text-dark">Profile Settings</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 p-4">
                <div class="card-header">
                    <h4 class="card-title text-dark mb-0">Profile Information</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="text-danger">Please correct the following errors:</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label text-secondary">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mt-4 mb-3 text-dark">Change Password</h5>
                        <p class="text-secondary">Leave password fields blank if you don't want to change your password.</p>

                        <div class="mb-3">
                            <label for="current_password" class="form-label text-secondary">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password" autocomplete="current-password">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label text-secondary">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                       id="new_password" name="new_password" autocomplete="new-password">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label text-secondary">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control"
                                       id="new_password_confirmation" name="new_password_confirmation" autocomplete="new-password">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('my-bookings.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4 p-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h4 class="card-title text-white mb-0">Danger Zone</h4>
                </div>
                <div class="card-body">
                    <p class="text-danger">
                        Once you delete your account, there is no going back. Please be certain.
                    </p>
                    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirmDeleteAccount()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">Delete My Account</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4">
                <div class="card-header">
                    <h4 class="card-title text-dark mb-0">Account Summary</h4>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-circle bg-primary text-white mx-auto mb-3" style="width: 80px; height: 80px; line-height: 80px; border-radius: 50%; font-size: 2rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="text-dark">{{ $user->name }}</h5>
                    <p class="text-secondary">{{ $user->email }}</p>
                    <hr>
                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item d-flex justify-content-between align-items-center text-secondary">
                            Member Since: <span class="text-dark">{{ $user->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-secondary">
                            Role: <span class="text-dark">{{ ucfirst($user->role ?? 'customer') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    const profileForm = document.getElementById('profileForm');
    const submitBtn = profileForm ? profileForm.querySelector('button[type="submit"]') : null;

    if (profileForm && submitBtn) {
        profileForm.addEventListener('submit', function(e) {
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
            submitBtn.disabled = true;
        });
    }
});

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.parentElement.querySelector('.toggle-password i');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function confirmDeleteAccount() {
    return confirm('Are you sure you want to delete your account? This action cannot be undone.');
}
</script>
@endsection
