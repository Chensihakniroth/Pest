@extends('layouts.auth')

@section('title', 'Create Account - GreenHome Pest Control')

@section('content')
<div class="auth-form">
    <div class="text-center mb-5">
        <div class="auth-icon mb-4">
            <div class="bg-gradient-primary rounded-circle text-white d-flex align-items-center justify-content-center mx-auto"
                 style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));">
                <i class="fas fa-user-plus fa-xl"></i>
            </div>
        </div>
        <h4 class="fw-bold text-dark mb-2">Create Account</h4>
        <p class="text-muted">Join GreenHome Pest Control</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <div class="mb-4">
            <label for="name" class="form-label">Full Name</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}"
                       placeholder="Enter your full name" required autofocus>
            </div>
            @error('name')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}"
                       placeholder="Enter your email" required>
            </div>
            @error('email')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="role" class="form-label">Role</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-user-tag"></i>
                </span>
                <select class="form-control @error('role') is-invalid @enderror"
                        id="role" name="role" required>
                    <option value="">Select your role</option>
                    <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            @error('role')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
            <small class="text-muted">Choose "Admin" for full system access</small>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" placeholder="Create a password" required
                       oninput="GreenHome.checkPasswordStrength(this.value, 'passwordStrengthBar', 'passwordStrengthText')">
                <button type="button" class="input-group-text toggle-password" data-target="password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <div class="password-strength mt-3">
                <div class="progress">
                    <div class="progress-bar" id="passwordStrengthBar" style="width: 0%"></div>
                </div>
                <small class="text-muted mt-1 d-block" id="passwordStrengthText">Password strength</small>
            </div>
            @error('password')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" class="form-control"
                       id="password_confirmation" name="password_confirmation"
                       placeholder="Confirm your password" required
                       oninput="GreenHome.checkPasswordMatch()">
                <button type="button" class="input-group-text toggle-password" data-target="password_confirmation">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <div class="mt-2">
                <small class="text-muted" id="passwordMatchText"></small>
            </div>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="#" class="auth-link">Terms of Service</a>
                    and <a href="#" class="auth-link">Privacy Policy</a>
                </label>
            </div>
            @error('terms')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-success btn-lg fw-semibold py-3" id="registerButton">
                <i class="fas fa-user-plus me-2"></i>Create Account
            </button>
        </div>

        <div class="text-center">
            <p class="text-muted mb-0">Already have an account?
                <a href="{{ route('login') }}" class="auth-link fw-semibold">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</div>

<style>
.auth-icon {
    transition: transform 0.3s ease;
}

.auth-icon:hover {
    transform: scale(1.05) rotate(5deg);
}

.form-check-input:checked {
    background-color: var(--gh-primary);
    border-color: var(--gh-primary);
}

.password-strength .progress {
    height: 6px;
    border-radius: 3px;
}
</style>
@endsection
