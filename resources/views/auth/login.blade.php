
@extends('layouts.auth')

@section('content')
<div class="auth-form">
    <div class="text-center mb-4">
        <div class="auth-icon mb-3">
            <div class="bg-gradient-primary rounded-circle text-white d-flex align-items-center justify-content-center mx-auto"
                 style="width: 60px; height: 60px;">
                <i class="fas fa-sign-in-alt fa-lg"></i>
            </div>
        </div>
        <h4 class="fw-bold text-dark mb-2">Welcome Back</h4>
        <p class="text-muted">Sign in to your GreenHome account</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $error)
                {{ $error }}@if(!$loop->last)<br>@endif
            @endforeach
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

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-envelope text-muted"></i>
                </span>
                <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}"
                       placeholder="Enter your email" required autofocus>
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label fw-semibold">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-lock text-muted"></i>
                </span>
                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror"
                       id="password" name="password" placeholder="Enter your password" required>
                <button type="button" class="input-group-text toggle-password" data-target="password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-success btn-lg fw-semibold py-2" id="loginButton">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
        </div>

        <div class="text-center">
            <p class="text-muted mb-0">Don't have an account?
                <a href="{{ route('register') }}" class="text-success fw-semibold text-decoration-none">
                    Create one here
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
    transform: scale(1.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus on email field
    const emailField = document.getElementById('email');
    if (emailField && !emailField.value) {
        setTimeout(() => {
            emailField.focus();
        }, 100);
    }

    // Add subtle animation to auth icon
    const authIcon = document.querySelector('.auth-icon');
    if (authIcon) {
        authIcon.style.animation = 'fadeInUp 0.6s ease';
    }
});
</script>
@endsection
