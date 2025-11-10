@extends('layouts.auth')

@section('content')
<div class="text-center mb-4">
    <h4 class="fw-bold text-dark mb-2">Welcome Back</h4>
    <p class="text-muted">Sign in to your account</p>
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

<style>
.auth-card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.auth-header {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    color: white;
    padding: 2.5rem 2rem;
    text-align: center;
    border-radius: 0;
}

.btn-success {
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
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

.toggle-password {
    cursor: pointer;
    border-left: none;
    border-radius: 0 8px 8px 0;
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
    border-left: none;
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
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');

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
    loginForm.addEventListener('submit', function(e) {
        // Basic validation
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            e.preventDefault();
            showError('Please fill in all required fields');
            return;
        }

        // Show loading state
        loginButton.classList.add('btn-loading');
        loginButton.disabled = true;

        // Allow form to submit normally
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
        const header = document.querySelector('.text-center');
        header.parentNode.insertBefore(alertDiv, header.nextSibling);
    }

    // Debug: Log form submission
    loginForm.addEventListener('submit', function() {
        console.log('Form submitted');
    });

    // Auto-focus on email field
    const emailField = document.getElementById('email');
    if (emailField && !emailField.value) {
        setTimeout(() => {
            emailField.focus();
        }, 100);
    }
});
</script>
@endsection
