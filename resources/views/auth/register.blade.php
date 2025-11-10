@extends('layouts.auth')

@section('content')
<div class="text-center mb-4">
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

    <div class="mb-3">
        <label for="name" class="form-label fw-semibold">Full Name</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-user text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name') }}"
                   placeholder="Enter your full name" required autofocus>
        </div>
        @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-envelope text-muted"></i>
            </span>
            <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email') }}"
                   placeholder="Enter your email" required>
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="role" class="form-label fw-semibold">Role</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-user-tag text-muted"></i>
            </span>
            <select class="form-control border-start-0 @error('role') is-invalid @enderror"
                    id="role" name="role" required>
                <option value="">Select your role</option>
                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        @error('role')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        <small class="text-muted">Choose "Admin" for full system access</small>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Password</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-lock text-muted"></i>
            </span>
            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror"
                   id="password" name="password" placeholder="Create a password" required
                   oninput="checkPasswordStrength(this.value)">
            <button type="button" class="input-group-text toggle-password" data-target="password">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        <div class="password-strength mt-2">
            <div class="progress" style="height: 4px;">
                <div class="progress-bar" id="passwordStrengthBar" style="width: 0%"></div>
            </div>
            <small class="text-muted" id="passwordStrengthText">Password strength</small>
        </div>
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-lock text-muted"></i>
            </span>
            <input type="password" class="form-control border-start-0"
                   id="password_confirmation" name="password_confirmation"
                   placeholder="Confirm your password" required
                   oninput="checkPasswordMatch()">
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
                I agree to the <a href="#" class="text-success text-decoration-none">Terms of Service</a>
                and <a href="#" class="text-success text-decoration-none">Privacy Policy</a>
            </label>
        </div>
        @error('terms')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-grid mb-4">
        <button type="submit" class="btn btn-success btn-lg fw-semibold py-2" id="registerButton">
            <i class="fas fa-user-plus me-2"></i>Create Account
        </button>
    </div>

    <div class="text-center">
        <p class="text-muted mb-0">Already have an account?
            <a href="{{ route('login') }}" class="text-success fw-semibold text-decoration-none">
                Sign in here
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

.btn-success:disabled {
    background: #6c757d;
    transform: none;
    box-shadow: none;
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

.form-select {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1);
}

.input-group-text {
    border-radius: 8px 0 0 8px;
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
    border-right: none;
}

.input-group .form-control,
.input-group .form-select {
    border-left: none;
    border-right: 1px solid #e0e0e0;
}

.input-group .form-control:focus,
.input-group .form-select:focus {
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

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f1aeb5 100%);
    color: #721c24;
}

.alert-success {
    background: linear-gradient(135deg, #d1e7dd 0%, #a3cfbb 100%);
    color: #0f5132;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.text-success {
    color: #198754 !important;
    font-weight: 600;
}

.text-success:hover {
    color: #146c43 !important;
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
@media (max-width: 576px) {
    .card-body {
        padding: 2rem 1.5rem;
    }

    .auth-header {
        padding: 2rem 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const registerButton = document.getElementById('registerButton');

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
    registerForm.addEventListener('submit', function(e) {
        // Basic validation
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const role = document.getElementById('role').value;
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        const terms = document.getElementById('terms').checked;

        if (!name || !email || !role || !password || !passwordConfirm || !terms) {
            e.preventDefault();
            showError('Please fill in all required fields and accept the terms');
            return;
        }

        if (password !== passwordConfirm) {
            e.preventDefault();
            showError('Passwords do not match');
            return;
        }

        // Show loading state
        registerButton.classList.add('btn-loading');
        registerButton.disabled = true;

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

    // Auto-focus on name field
    const nameField = document.getElementById('name');
    if (nameField && !nameField.value) {
        setTimeout(() => {
            nameField.focus();
        }, 100);
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
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
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
