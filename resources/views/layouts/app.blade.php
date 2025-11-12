<!DOCTYPE html>
<html lang="en" class="{{ session('dark_mode') ? 'dark-mode' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenHome Pest Control</title>

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

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gh-background);
            color: var(--gh-text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Modern Navbar */
        .navbar {
            background: var(--gh-surface);
            border-bottom: 1px solid var(--gh-border);
            box-shadow: var(--gh-shadow);
            padding: 1rem 0;
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .brand-primary {
            font-weight: 700;
            color: var(--gh-text);
            font-size: 1.125rem;
        }

        .brand-secondary {
            font-weight: 400;
            color: var(--gh-text-light);
            font-size: 0.75rem;
        }

        /* Navigation */
        .navbar-nav {
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--gh-text-light);
            transition: all 0.2s ease;
        }

        .nav-item:hover,
        .nav-item.active {
            background: var(--gh-primary);
            color: white;
        }

        .nav-icon {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        main {
            flex: 1;
            padding: 1.5rem 0;
        }

        /* Compact Dark Mode Toggle */
        .dark-mode-section {
            margin: 1rem 0;
        }

        .dark-mode-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem;
            background: var(--gh-surface);
            border: 1px solid var(--gh-border);
            border-radius: 12px;
            max-width: 180px;
            margin: 0 auto;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
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
            background: var(--gh-border);
            transition: .4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background: var(--gh-primary);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(20px);
        }

        .toggle-icon {
            font-size: 0.75rem;
            color: var(--gh-text-light);
            flex-shrink: 0;
        }

        .toggle-label {
            font-size: 0.75rem;
            color: var(--gh-text-light);
            font-weight: 500;
            min-width: 40px;
            text-align: center;
        }

        /* Modern Footer */
        .main-footer {
            background: var(--gh-surface);
            border-top: 1px solid var(--gh-border);
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
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--gh-text);
        }

        .footer-text {
            color: var(--gh-text-light);
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .footer-copyright {
            color: var(--gh-text-light);
            font-size: 0.75rem;
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
        .card, .btn, .nav-item, .table tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body>
    <!-- Enhanced Modern Navbar -->
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <span class="nav-text">Profile</span>
                        </a>

                        <!-- User Menu with Dropdown -->
                        <div class="nav-item dropdown user-menu">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-btn">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
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

                        <a class="nav-item nav-item-primary" href="{{ route('register') }}">
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
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                <p class="footer-text">Professional pest control & customer management</p>

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
                    &copy; {{ date('Y') }} GreenHome. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vite JS -->
    @vite(['resources/js/app.js'])

    @stack('scripts')
</body>
</html>
