@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Modern Header matching your dashboard -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-text">
                <h1 class="dashboard-title">Profile Settings</h1>
                <p class="dashboard-subtitle">Manage your account information and security preferences</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn-back-dashboard">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column - Profile Information & Actions -->
        <div class="col-lg-8">
            <!-- Profile Information Card -->
            <div class="section-card glass-morphism">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-user-circle"></i>
                        <span>Profile Information</span>
                    </div>
                    <div class="section-info">
                        <span class="status-badge active">Active Account</span>
                    </div>
                </div>

                <div class="section-content">
                    <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                        @csrf
                        @method('PATCH')

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert-success">
                                <i class="fas fa-check-circle"></i>
                                {{ session('success') }}
                                <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

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

                        <div class="form-grid">
                            <!-- Name Field -->
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i>
                                    Full Name
                                </label>
                                <div class="input-container">
                                    <input type="text"
                                           class="modern-input @error('name') error @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $user->name) }}"
                                           required
                                           autocomplete="name"
                                           placeholder="Enter your full name">
                                    <div class="input-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                @error('name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    Email Address
                                </label>
                                <div class="input-container">
                                    <input type="email"
                                           class="modern-input @error('email') error @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $user->email) }}"
                                           required
                                           autocomplete="email"
                                           placeholder="Enter your email address">
                                    <div class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Change Section -->
                        <div class="section-divider">
                            <div class="divider-content">
                                <i class="fas fa-lock"></i>
                                <span>Change Password</span>
                            </div>
                        </div>

                        <p class="section-description">Leave password fields blank if you don't want to change your password.</p>

                        <div class="form-grid">
                            <!-- Current Password -->
                            <div class="form-group">
                                <label for="current_password" class="form-label">
                                    <i class="fas fa-key"></i>
                                    Current Password
                                </label>
                                <div class="input-container">
                                    <input type="password"
                                           class="modern-input @error('current_password') error @enderror"
                                           id="current_password"
                                           name="current_password"
                                           autocomplete="current-password"
                                           placeholder="Enter current password">
                                    <div class="input-icon">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="form-group">
                                <label for="new_password" class="form-label">
                                    <i class="fas fa-lock"></i>
                                    New Password
                                </label>
                                <div class="input-container">
                                    <input type="password"
                                           class="modern-input @error('new_password') error @enderror"
                                           id="new_password"
                                           name="new_password"
                                           autocomplete="new-password"
                                           placeholder="Enter new password">
                                    <div class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <button type="button" class="password-toggle" onclick="togglePassword('new_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label">
                                    <i class="fas fa-lock"></i>
                                    Confirm New Password
                                </label>
                                <div class="input-container">
                                    <input type="password"
                                           class="modern-input"
                                           id="new_password_confirmation"
                                           name="new_password_confirmation"
                                           autocomplete="new-password"
                                           placeholder="Confirm new password">
                                    <div class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <button type="button" class="password-toggle" onclick="togglePassword('new_password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save"></i>
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone Card -->
            <div class="section-card glass-morphism danger-zone">
                <div class="section-header danger-header">
                    <div class="section-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Danger Zone</span>
                    </div>
                </div>
                <div class="section-content danger-content">
                    <p class="danger-description">
                        Once you delete your account, there is no going back. Please be certain.
                    </p>
                    <form action="{{ route('profile.destroy') }}" method="POST"
                          onsubmit="return confirmDeleteAccount()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete My Account
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Account Summary -->
        <div class="col-lg-4">
            <!-- Account Summary Card -->
            <div class="section-card glass-morphism account-summary">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-id-card"></i>
                        <span>Account Summary</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="account-avatar-container">
                        <div class="account-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="account-info">
                            <h4 class="account-name">{{ $user->name }}</h4>
                            <p class="account-email">{{ $user->email }}</p>
                            <span class="status-badge active">
                                <i class="fas fa-check-circle"></i>
                                Active
                            </span>
                        </div>
                    </div>

                    <div class="account-stats">
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="fas fa-calendar"></i>
                                Member since
                            </div>
                            <div class="stat-value">{{ $user->created_at->format('M Y') }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="fas fa-user-tag"></i>
                                Role
                            </div>
                            <div class="stat-value">Administrator</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="fas fa-shield-alt"></i>
                                Status
                            </div>
                            <div class="stat-value verified">Verified</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Tips Card -->
            <div class="section-card glass-morphism tips-card">
                <div class="section-header">
                    <div class="section-title">
                        <i class="fas fa-lightbulb"></i>
                        <span>Profile Tips</span>
                    </div>
                </div>
                <div class="section-content">
                    <div class="tips-list">
                        <div class="tip-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Keep your email updated for notifications</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Use a strong, unique password</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Regularly review your account security</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile-specific styles matching your dashboard design */
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Modern Header matching your dashboard */
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

/* Section Cards matching your design */
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

/* Form Styles */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
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

.password-toggle {
    position: absolute;
    right: 1rem;
    background: none;
    border: none;
    color: var(--gh-text-light);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.password-toggle:hover {
    color: var(--gh-primary);
    background: rgba(16, 185, 129, 0.1);
}

.error-message {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

/* Alerts */
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

.section-description {
    color: var(--gh-text-light);
    font-size: 0.875rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--gh-glass-border);
}

/* Buttons */
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

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
    background: linear-gradient(135deg, #dc2626, #b91c1c);
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

/* Danger Zone */
.danger-zone {
    border: 1.5px solid #fecaca;
}

.danger-header {
    border-bottom: 1.5px solid #fecaca;
}

.danger-header .section-title {
    color: #dc2626;
}

.danger-header .section-title i {
    color: #dc2626;
}

.danger-content {
    text-align: center;
}

.danger-description {
    color: var(--gh-text-light);
    font-size: 0.875rem;
    margin-bottom: 1.5rem;
}

/* Account Summary */
.account-summary {
    height: fit-content;
}

.account-avatar-container {
    text-align: center;
    margin-bottom: 1.5rem;
}

.account-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 600;
    color: white;
    margin: 0 auto 1rem;
    transition: all 0.3s ease;
}

.account-avatar:hover {
    transform: scale(1.05);
}

.account-info {
    text-align: center;
}

.account-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gh-text);
    margin-bottom: 0.25rem;
}

.account-email {
    color: var(--gh-text-light);
    font-size: 0.875rem;
    margin-bottom: 1rem;
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

/* Account Stats */
.account-stats {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border: 1px solid var(--gh-glass-border);
}

.stat-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--gh-text-light);
}

.stat-value {
    font-weight: 600;
    color: var(--gh-text);
    font-size: 0.875rem;
}

.stat-value.verified {
    color: #10b981;
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

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
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

.dark .danger-zone {
    border-color: #991b1b;
}

.dark .danger-header {
    border-bottom-color: #991b1b;
}

.dark .stat-item,
.dark .tip-item {
    background: rgba(255, 255, 255, 0.02);
    border-color: rgba(255, 255, 255, 0.1);
}
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
    const submitBtn = document.getElementById('submitBtn');

    if (profileForm && submitBtn) {
        profileForm.addEventListener('submit', function(e) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;
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
});

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggle = field.parentElement.querySelector('.password-toggle i');

    if (field.type === 'password') {
        field.type = 'text';
        toggle.className = 'fas fa-eye-slash';
    } else {
        field.type = 'password';
        toggle.className = 'fas fa-eye';
    }
}

// Confirm account deletion
function confirmDeleteAccount() {
    return confirm('Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently lost.');
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
