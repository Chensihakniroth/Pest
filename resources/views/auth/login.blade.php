@extends('layouts.auth')

@section('title', 'Login - GreenHome Pest Control')

@section('content')
<div class="auth-form">
    <div class="text-center mb-5">
        <div class="auth-icon mb-4">
            <div class="bg-gradient-primary rounded-circle text-white d-flex align-items-center justify-content-center mx-auto"
                 style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));">
                <i class="fas fa-sign-in-alt fa-xl"></i>
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

        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}"
                       placeholder="Enter your email" required autofocus>
            </div>
            @error('email')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" placeholder="Enter your password" required>
                <button type="button" class="input-group-text toggle-password" data-target="password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-success btn-lg fw-semibold py-3" id="loginButton">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
        </div>

        <div class="text-center">
            <p class="text-muted mb-0">Don't have an account?
                <a href="{{ route('register') }}" class="auth-link fw-semibold">
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
    transform: scale(1.05) rotate(5deg);
}

.form-check-input:checked {
    background-color: var(--gh-primary);
    border-color: var(--gh-primary);
}
</style>
@endsection
