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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --gh-primary: #10b981;
            --gh-primary-dark: #059669;
            --gh-primary-light: #34d399;
            --gh-secondary: #6b7280;
            --gh-accent: #3b82f6;
            --gh-success: #10b981;
            --gh-warning: #f59e0b;
            --gh-danger: #ef4444;
            --gh-surface: #ffffff;
            --gh-background: #f8fafc;
            --gh-text: #1e293b;
            --gh-text-light: #64748b;
            --gh-border: #e2e8f0;
            --gh-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --gh-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --gh-glass: rgba(255, 255, 255, 0.95);
            --gh-glass-border: rgba(255, 255, 255, 0.2);
        }

        .dark-mode {
            --gh-surface: #1e293b;
            --gh-background: #0f172a;
            --gh-text: #f1f5f9;
            --gh-text-light: #cbd5e1;
            --gh-border: #334155;
            --gh-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.3);
            --gh-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.3);
            --gh-glass: rgba(30, 30, 30, 0.95);
            --gh-glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gh-background);
            color: var(--gh-text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Ultra Modern Navbar */
        .navbar {
            background: var(--gh-glass);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gh-glass-border);
            box-shadow: var(--gh-shadow);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.25rem 0;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }

        .brand-icon:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .brand-primary {
            font-weight: 800;
            color: var(--gh-text);
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-secondary {
            font-weight: 500;
            color: var(--gh-text-light);
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        /* Navigation */
        .navbar-nav {
            gap: 0.25rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            border-radius: 12px;
            text-decoration: none;
            color: var(--gh-text-light);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1.5px solid transparent;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .nav-item:hover {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            border-color: transparent;
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
        }

        .nav-text {
            font-weight: 500;
            white-space: nowrap;
        }

        /* User Menu - SIMPLIFIED DROPDOWN */
        .user-menu .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 12px;
            border: 1.5px solid var(--gh-border);
            transition: all 0.3s ease;
            background: var(--gh-glass);
            backdrop-filter: blur(10px);
            text-decoration: none;
            color: var(--gh-text-light);
        }

        .user-menu .dropdown-toggle:hover {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border-color: transparent;
            transform: translateY(-1px);
            color: white;
        }

        .user-menu .dropdown-toggle:hover .user-name,
        .user-menu .dropdown-toggle:hover .dropdown-arrow {
            color: white;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .user-name {
            font-weight: 500;
            color: var(--gh-text);
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: color 0.3s ease;
        }

        .dropdown-arrow {
            font-size: 0.7rem;
            opacity: 0.7;
            transition: all 0.3s ease;
            color: var(--gh-text-light);
        }

        .user-menu.show .dropdown-arrow {
            transform: rotate(180deg);
        }

        /* Dropdown Menu - LET BOOTSTRAP HANDLE POSITIONING */
        .user-menu .dropdown-menu {
            background: var(--gh-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--gh-glass-border);
            border-radius: 16px;
            box-shadow: var(--gh-shadow-lg);
            padding: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-weight: 500;
            color: var(--gh-text);
            transition: all 0.3s ease;
            border: none;
            font-size: 0.875rem;
            text-decoration: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white;
            transform: translateX(4px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
        }

        /* Main Content */
        main {
            flex: 1;
            padding: 1.5rem 0;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
            color: var(--gh-text);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
            color: var(--gh-text);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Ultra Modern Slim Footer */
        .main-footer {
            background: var(--gh-glass);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--gh-glass-border);
            padding: 1.5rem 0;
            margin-top: auto;
        }

        .footer-content {
            text-align: center;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            font-weight: 700;
            color: var(--gh-text);
            font-size: 1.1rem;
        }

        .footer-brand i {
            color: var(--gh-primary);
        }

        .footer-text {
            color: var(--gh-text-light);
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .footer-copyright {
            color: var(--gh-text-light);
            font-size: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gh-border);
        }

        /* Compact Dark Mode Toggle */
        .dark-mode-section {
            margin: 1rem 0 0.5rem;
        }

        .dark-mode-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: var(--gh-glass);
            border: 1px solid var(--gh-glass-border);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            max-width: 200px;
            margin: 0 auto;
        }

        .dark-mode-toggle:hover {
            border-color: var(--gh-primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--gh-secondary), #9ca3af);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 24px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked + .toggle-slider {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
        }

        input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }

        .toggle-icon {
            font-size: 0.8rem;
            color: var(--gh-text-light);
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .toggle-icon.sun {
            color: #f59e0b;
        }

        .toggle-icon.moon {
            color: #cbd5e1;
        }

        input:checked ~ .toggle-icon.sun {
            transform: scale(0.8);
            opacity: 0.7;
        }

        input:not(:checked) ~ .toggle-icon.moon {
            transform: scale(0.8);
            opacity: 0.7;
        }

        .toggle-label {
            font-size: 0.75rem;
            color: var(--gh-text-light);
            font-weight: 600;
            min-width: 45px;
            text-align: center;
            letter-spacing: -0.2px;
        }

        /* Enhanced loading states */
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

        /* Smooth transitions */
        .card, .btn, .nav-item, .table tr, .dropdown-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .navbar-nav {
                gap: 0.5rem;
                padding: 1rem 0;
            }

            .brand-text {
                display: none;
            }

            .user-name {
                display: none;
            }

            .nav-item {
                padding: 0.75rem 1rem;
                justify-content: center;
            }

            .nav-text {
                font-size: 0.8rem;
            }

            .dark-mode-toggle {
                padding: 0.6rem 0.8rem;
                gap: 0.6rem;
            }

            .toggle-switch {
                width: 44px;
                height: 22px;
            }

            .toggle-slider:before {
                height: 16px;
                width: 16px;
            }

            input:checked + .toggle-slider:before {
                transform: translateX(22px);
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gh-background);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--gh-primary-dark), #047857);
        }

        /* Container fluid padding */
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        @media (min-width: 1200px) {
            .container-fluid {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        /* Glass morphism utility */
        .glass-morphism {
            background: var(--gh-glass);
            backdrop-filter: blur(10px);
            border: 1px solid var(--gh-glass-border);
            border-radius: 12px;
        }

        /* Custom button styles */
        .btn-gh-primary {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gh-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        /* Animation classes */
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

        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Focus states for accessibility */
        .nav-item:focus,
        .dropdown-item:focus,
        .btn:focus {
            outline: 2px solid var(--gh-primary);
            outline-offset: 2px;
        }

        /* Print styles */
        @media print {
            .navbar,
            .main-footer {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Ultra Modern Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Brand Logo with Modern Design -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <div class="brand-container">
                    <div class="brand-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="brand-text">
                        <span class="brand-primary">GreenHome</span>
                        <span class="brand-secondary">Pest Control</span>
                    </div>
                </div>
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                    style="border: 1.5px solid var(--gh-border); border-radius: 10px; padding: 0.5rem 0.75rem;">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-center">
                    @auth
                        <!-- Dashboard -->
                        <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <div class="nav-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <span class="nav-text">Dashboard</span>
                        </a>

                        <!-- Customers -->
                        <a class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                           href="{{ route('customers.index') }}">
                            <div class="nav-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="nav-text">Customers</span>
                        </a>

                        <!-- Profile -->
                        <a class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                           href="{{ route('profile.edit') }}">
                            <div class="nav-icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <span class="nav-text">Profile</span>
                        </a>

                        <!-- User Menu with Dropdown - SIMPLIFIED -->
                        <div class="nav-item dropdown user-menu">
                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-edit"></i>Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i>Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-btn w-100 text-start border-0 bg-transparent">
                                            <i class="fas fa-sign-out-alt"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                    @else
                        <!-- Guest Navigation -->
                        <a class="nav-item" href="{{ route('login') }}">
                            <div class="nav-icon">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <span class="nav-text">Login</span>
                        </a>

                        <a class="nav-item" href="{{ route('register') }}"
                           style="background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark)); color: white;">
                            <div class="nav-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <span class="nav-text">Register</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 fade-in-up" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div class="flex-grow-1">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 fade-in-up" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div class="flex-grow-1">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Ultra Modern Slim Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <i class="fas fa-leaf"></i>
                    <span>GreenHome Pest Control</span>
                </div>
                <p class="footer-text">Professional pest control & customer management system</p>

                <!-- Compact Dark Mode Toggle -->
                <div class="dark-mode-section">
                    <form method="POST" action="/dark-mode/toggle" id="darkModeForm">
                        @csrf
                        <div class="dark-mode-toggle">
                            <i class="fas fa-sun toggle-icon sun"></i>
                            <label class="toggle-switch">
                                <input type="checkbox" id="darkModeToggle" name="dark_mode"
                                       {{ session('dark_mode') ? 'checked' : '' }}
                                       onchange="document.getElementById('darkModeForm').submit()">
                                <span class="toggle-slider"></span>
                            </label>
                            <i class="fas fa-moon toggle-icon moon"></i>
                            <span class="toggle-label" id="darkModeLabel">
                                {{ session('dark_mode') ? 'Dark' : 'Light' }}
                            </span>
                        </div>
                    </form>
                </div>

                <div class="footer-copyright">
                    &copy; {{ date('Y') }} GreenHome Pest Control. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vite JS -->
    @vite(['resources/js/app.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced navbar scroll effect
            let lastScrollTop = 0;
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    // Scrolling up
                    navbar.style.transform = 'translateY(0)';
                }

                lastScrollTop = scrollTop;
            });

            // Update dropdown arrow rotation when Bootstrap toggles dropdown
            const userMenu = document.querySelector('.user-menu');
            if (userMenu) {
                const dropdownToggle = userMenu.querySelector('.dropdown-toggle');
                const dropdownArrow = userMenu.querySelector('.dropdown-arrow');

                dropdownToggle.addEventListener('show.bs.dropdown', function () {
                    dropdownArrow.style.transform = 'rotate(180deg)';
                });

                dropdownToggle.addEventListener('hide.bs.dropdown', function () {
                    dropdownArrow.style.transform = 'rotate(0deg)';
                });
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            });

            // Enhanced dark mode toggle label update
            const darkModeToggle = document.getElementById('darkModeToggle');
            const darkModeLabel = document.getElementById('darkModeLabel');

            if (darkModeToggle && darkModeLabel) {
                darkModeToggle.addEventListener('change', function() {
                    darkModeLabel.textContent = this.checked ? 'Dark' : 'Light';
                });
            }

            // Add loading state to forms
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.classList.contains('btn-loading')) {
                        submitBtn.classList.add('btn-loading');
                        submitBtn.disabled = true;

                        // Re-enable after 10 seconds in case of error
                        setTimeout(() => {
                            submitBtn.classList.remove('btn-loading');
                            submitBtn.disabled = false;
                        }, 10000);
                    }
                });
            });

            console.log('GreenHome Pest Control System initialized');
        });

        // Utility function for making AJAX requests
        function makeRequest(url, options = {}) {
            return fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    ...options.headers
                },
                ...options
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
