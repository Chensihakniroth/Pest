<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenHome Pest Control - Professional Pest Management</title>

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="welcome-page">
    <!-- Enhanced Navigation - Clean & Simple -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top welcome-navbar">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="/">
                <i class="fas fa-home"></i>
                GreenHome Pest Control
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-center">
                    @auth
                        <!-- Logged-in User -->
                        <div class="nav-user-info">
                            <div class="nav-user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="nav-user-name d-none d-md-block">
                                {{ Auth::user()->name }}
                            </div>
                        </div>

                        <!-- Dashboard Button -->
                        <a class="btn btn-nav-primary ms-2" href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line"></i>Dashboard
                        </a>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                            @csrf
                            <button type="submit" class="btn btn-nav-outline">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </button>
                        </form>

                    @else
                        <!-- Guest User - Simple Button Layout -->
                        <a class="btn btn-nav-primary me-2" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i>Login
                        </a>

                        <a class="btn btn-nav-outline" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i>Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center hero-content fade-in-up">
                    <span class="hero-badge">
                        <i class="fas fa-shield-alt me-2"></i>Professional Pest Control Management
                    </span>
                    <h1 class="display-4 fw-bold">
                        Complete Customer Management<br>
                        <span class="text-warning">Made Simple</span>
                    </h1>
                    <p class="hero-lead">
                        Streamline your pest control business with our comprehensive management system.
                        Track customers, schedule maintenance, and grow your business efficiently.
                    </p>
                    <div class="hero-buttons">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-hero btn-hero-primary">
                                Go to Dashboard <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-hero btn-hero-primary">
                                <i class="fas fa-sign-in-alt me-2"></i> Sign In
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-hero btn-hero-outline">
                                <i class="fas fa-user-plus me-2"></i> Create Account
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-title fade-in-up">
                <h2>Everything You Need to Manage Your Business</h2>
                <p>Powerful tools designed specifically for pest control companies</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Customer Management</h4>
                        <p>Easily manage all your customers with detailed profiles, service history, and contact information in one centralized system.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.1s;">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4>Smart Alerts</h4>
                        <p>Never miss important dates with automatic maintenance reminders and contract expiration alerts sent directly to you.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.2s;">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Dashboard Analytics</h4>
                        <p>Get a comprehensive overview of your business with real-time statistics, performance metrics, and growth insights.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.3s;">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4>Maintenance Scheduling</h4>
                        <p>Automated maintenance schedules based on service types with completion tracking and history logs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.4s;">
                        <div class="feature-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h4>Contract Management</h4>
                        <p>Track contract dates, automate renewals, and manage service agreements with expiration alerts.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.5s;">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Location Services</h4>
                        <p>Integrated Google Maps links for easy navigation to customer locations and route optimization.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 stat-item">
                    <div class="stat-number" data-count="100">0</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="col-lg-3 col-md-6 stat-item">
                    <div class="stat-number" data-count="24">0</div>
                    <div class="stat-label">Hours Support</div>
                </div>
                <div class="col-lg-3 col-md-6 stat-item">
                    <div class="stat-number" data-count="99">0</div>
                    <div class="stat-label">% Uptime</div>
                </div>
                <div class="col-lg-3 col-md-6 stat-item">
                    <div class="stat-number" data-count="5">0</div>
                    <div class="stat-label">Star Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content fade-in-up">
                <h3>Ready to Transform Your Business?</h3>
                <p>Join pest control professionals who trust our system to manage their operations efficiently.</p>
                @auth
                    <a href="{{ route('customers.index') }}" class="btn btn-hero btn-hero-primary">
                        Manage Customers <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-hero btn-hero-primary">
                        <i class="fas fa-user-plus me-2"></i> Get Started Now
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="welcome-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">
                        <i class="fas fa-home"></i>
                        GreenHome Pest Control
                    </div>
                    <p class="footer-text">
                        Professional pest control management system designed to streamline your operations,
                        enhance customer service, and grow your business.
                    </p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><a href="#features">Features</a></li>
                            @auth
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('customers.index') }}">Customers</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Features</h5>
                        <ul>
                            <li><a href="#features">Customer Management</a></li>
                            <li><a href="#features">Maintenance Tracking</a></li>
                            <li><a href="#features">Contract Alerts</a></li>
                            <li><a href="#features">Analytics Dashboard</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Contact</h5>
                        <ul>
                            <li><i class="fas fa-envelope me-2"></i> support@greenhome.com</li>
                            <li><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                            <li><i class="fas fa-map-marker-alt me-2"></i> Pest Control HQ</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 GreenHome Pest Control. All rights reserved. | Professional Pest Management System</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vite JS -->
    @vite(['resources/js/app.js'])
</body>
</html>
