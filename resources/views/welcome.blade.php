<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenHome Pest Control - Professional Pest Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #198754;
            --dark-green: #146c43;
            --light-green: #d1e7dd;
            --gradient-primary: linear-gradient(135deg, #198754 0%, #146c43 100%);
            --gradient-success: linear-gradient(135deg, #198754 0%, #0d6efd 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Enhanced Navigation */
        .navbar {
            background: var(--gradient-primary) !important;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-scrolled {
            background: var(--gradient-primary) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 30px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white !important;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: translateY(-1px);
        }

        .navbar-brand i {
            font-size: 1.8rem;
            background: rgba(255,255,255,0.2);
            padding: 10px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover i {
            background: rgba(255,255,255,0.3);
            transform: scale(1.1);
        }

        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.3);
            padding: 0.5rem 0.75rem;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px rgba(255,255,255,0.25);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .btn-nav-primary {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-nav-primary:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.2);
        }

        .btn-nav-outline {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-nav-outline:hover {
            background: white;
            color: var(--primary-green);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.2);
        }

        .nav-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            margin-left: 1rem;
        }

        .nav-user-avatar {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .nav-user-name {
            color: white;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Hero Section */
        .hero-section {
            background: var(--gradient-primary);
            color: white;
            padding: 120px 0 100px;
            position: relative;
            overflow: hidden;
            margin-top: 76px; /* Account for fixed navbar */
        }

        /* ... rest of the existing styles remain the same ... */

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.05"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .display-4 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-lead {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 2.5rem;
            font-weight: 300;
        }

        .btn-hero {
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            margin: 0 10px 15px;
            border: 2px solid transparent;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary-green);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255,255,255,0.2);
        }

        .btn-hero-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--primary-green);
            transform: translateY(-3px);
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-weight: 700;
            color: var(--dark-green);
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.2rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(25, 135, 84, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-card h4 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-green);
        }

        .feature-card p {
            color: #6c757d;
            line-height: 1.7;
        }

        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: white;
        }

        .stat-item {
            text-align: center;
            padding: 2rem 1rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            color: #6c757d;
            font-weight: 500;
        }

        /* CTA Section */
        .cta-section {
            background: var(--gradient-success);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-content h3 {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }

        .cta-content p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        .main-footer {
            background: #1a1a1a;
            color: white;
            padding: 60px 0 30px;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-brand i {
            color: var(--primary-green);
        }

        .footer-text {
            color: #adb5bd;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }

        .footer-links h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-green);
        }

        .footer-bottom {
            border-top: 1px solid #2d2d2d;
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: #6c757d;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 100px 0 80px;
                text-align: center;
                margin-top: 66px;
            }

            .display-4 {
                font-size: 2.5rem;
            }

            .hero-lead {
                font-size: 1.1rem;
            }

            .btn-hero {
                display: block;
                width: 100%;
                max-width: 280px;
                margin: 10px auto;
            }

            .features-section,
            .stats-section {
                padding: 60px 0;
            }

            .feature-card {
                margin-bottom: 2rem;
            }

            .nav-user-info {
                margin-left: 0;
                margin-top: 1rem;
                justify-content: center;
            }

            .navbar-nav {
                text-align: center;
                padding: 1rem 0;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .display-4 {
                font-size: 2rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .btn-nav-primary,
            .btn-nav-outline {
                width: 100%;
                justify-content: center;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Enhanced Navigation - Clean & Simple -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
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
    <footer class="main-footer">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });

            // Animate stats counter
            const statNumbers = document.querySelectorAll('.stat-number');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        const target = parseInt(element.getAttribute('data-count'));
                        const duration = 2000;
                        const step = target / (duration / 16);
                        let current = 0;

                        const timer = setInterval(() => {
                            current += step;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            element.textContent = Math.floor(current);
                        }, 16);

                        observer.unobserve(element);
                    }
                });
            }, { threshold: 0.5 });

            statNumbers.forEach(stat => observer.observe(stat));

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

            // Mobile menu close on click
            const navLinks = document.querySelectorAll('.nav-link');
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');

            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (navbarCollapse.classList.contains('show')) {
                        navbarToggler.click();
                    }
                });
            });
        });
    </script>
</body>
</html>
