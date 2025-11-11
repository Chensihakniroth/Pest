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
</head>
<body>
    <!-- Enhanced Modern Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <!-- Brand Logo with Modern Design -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <div class="brand-container">
                    <div class="brand-icon">
                        <i class="fas fa-home"></i>
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
    <main class="container mt-4">
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
                    <i class="fas fa-home"></i>
                    <span>GreenHome Pest Control</span>
                </div>
                <p class="footer-text">Professional pest control & customer management</p>

                <!-- Ultra Modern Dark Mode Toggle -->
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
