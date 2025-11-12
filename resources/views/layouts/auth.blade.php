<!DOCTYPE html>
<html lang="en" class="{{ session('dark_mode') ? 'dark-mode' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GreenHome Pest Control')</title>

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --gh-primary: #10b981;
            --gh-primary-dark: #059669;
            --gh-primary-light: #34d399;
            --gh-surface: #ffffff;
            --gh-background: #f8fafc;
            --gh-text: #1e293b;
            --gh-text-light: #64748b;
            --gh-border: #e2e8f0;
            --gh-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --gh-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --gh-blur: blur(20px);
        }

        .dark-mode {
            --gh-surface: #1e293b;
            --gh-background: #0f172a;
            --gh-text: #f1f5f9;
            --gh-text-light: #cbd5e1;
            --gh-border: #334155;
            --gh-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.3);
            --gh-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: subtleShift 20s ease-in-out infinite;
        }

        @keyframes subtleShift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-10px, -10px) scale(1.02); }
        }

        .auth-container {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 2;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: var(--gh-blur);
            -webkit-backdrop-filter: var(--gh-blur);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark-mode .auth-card {
            background: rgba(30, 41, 59, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .auth-card:hover {
            transform: translateY(-2px);
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2);
        }

        .auth-header {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .auth-header h4 {
            font-weight: 700;
            font-size: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .auth-header p {
            font-size: 0.875rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .auth-body {
            padding: 2rem;
        }

        /* Form Elements */
        .form-label {
            font-weight: 500;
            color: var(--gh-text);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .input-group-text {
            background: var(--gh-background);
            border: 1px solid var(--gh-border);
            border-right: none;
            color: var(--gh-text-light);
            transition: all 0.2s ease;
        }

        .form-control {
            border: 1px solid var(--gh-border);
            border-left: none;
            background: var(--gh-surface);
            color: var(--gh-text);
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            border-color: var(--gh-primary);
        }

        .form-control:focus + .input-group-text {
            border-color: var(--gh-primary);
            color: var(--gh-primary);
        }

        /* Buttons */
        .btn-success {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-success::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-success:hover::before {
            left: 100%;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        /* Toggle Password */
        .toggle-password {
            cursor: pointer;
            background: var(--gh-background);
            border: 1px solid var(--gh-border);
            border-left: none;
            color: var(--gh-text-light);
            transition: all 0.2s ease;
        }

        .toggle-password:hover {
            color: var(--gh-primary);
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        /* Password Strength */
        .password-strength .progress {
            height: 4px;
            border-radius: 2px;
            background: var(--gh-border);
        }

        .password-strength .progress-bar {
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Links */
        .auth-link {
            color: var(--gh-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .auth-link:hover {
            color: var(--gh-primary-dark);
            text-decoration: underline;
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

        .auth-card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-card {
                margin: 0.5rem;
            }

            .auth-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="card auth-card">
            <div class="auth-header">
                <h4 class="mb-0">
                    <i class="fas fa-leaf me-2"></i>GreenHome
                </h4>
                <p class="mb-0 mt-2 opacity-75">Pest Control Management</p>
            </div>
            <div class="auth-body">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vite JS -->
    @vite(['resources/js/app.js'])

    <script>
        // Enhanced form interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const toggleButtons = document.querySelectorAll('.toggle-password');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    const input = document.getElementById(target);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Form submission loading states
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('btn-loading');
                        submitBtn.disabled = true;
                    }
                });
            });

            // Auto-focus first input
            const firstInput = document.querySelector('form input:not([type="hidden"])');
            if (firstInput) {
                setTimeout(() => {
                    firstInput.focus();
                }, 400);
            }
        });

        // Password strength checker
        const GreenHome = {
            checkPasswordStrength: function(password, barId, textId) {
                const bar = document.getElementById(barId);
                const text = document.getElementById(textId);
                let strength = 0;

                if (password.length >= 8) strength += 25;
                if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
                if (password.match(/\d/)) strength += 25;
                if (password.match(/[^a-zA-Z\d]/)) strength += 25;

                bar.style.width = strength + '%';

                if (strength < 50) {
                    bar.style.background = '#ef4444';
                    text.textContent = 'Weak password';
                } else if (strength < 75) {
                    bar.style.background = '#f59e0b';
                    text.textContent = 'Medium password';
                } else {
                    bar.style.background = '#10b981';
                    text.textContent = 'Strong password';
                }
            },

            checkPasswordMatch: function() {
                const password = document.getElementById('password').value;
                const confirm = document.getElementById('password_confirmation').value;
                const text = document.getElementById('passwordMatchText');

                if (!confirm) {
                    text.textContent = '';
                    return;
                }

                if (password === confirm) {
                    text.textContent = 'Passwords match';
                    text.style.color = '#10b981';
                } else {
                    text.textContent = 'Passwords do not match';
                    text.style.color = '#ef4444';
                }
            }
        };
    </script>
</body>
</html>
