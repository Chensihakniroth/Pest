<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenHome Pest Control - Professional Pest Management Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --gh-primary: #10b981;
            --gh-primary-dark: #059669;
            --gh-secondary: #047857;
            --gh-accent: #f59e0b;
            --gh-dark: #1f2937;
            --gh-light: #f8fafc;
            --gh-text: #374151;
            --gh-text-light: #6b7280;
            --gh-glass: rgba(255, 255, 255, 0.95);
            --gh-glass-border: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--gh-text);
            background: var(--gh-light);
            overflow-x: hidden;
        }

        /* Modern Navigation */
        .navbar {
            background: var(--gh-glass);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--gh-dark) !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--gh-text) !important;
            margin: 0 0.25rem;
            padding: 0.75rem 1.25rem !important;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--gh-primary) !important;
            background: rgba(16, 185, 129, 0.05);
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: var(--gh-primary) !important;
            background: rgba(16, 185, 129, 0.1);
        }

        .admin-login {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white !important;
            border-radius: 10px;
            padding: 0.75rem 1.5rem !important;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .admin-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            background: linear-gradient(135deg, var(--gh-primary-dark), var(--gh-secondary));
            color: white !important;
        }

        /* Enhanced Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--gh-primary) 0%, var(--gh-primary-dark) 100%);
            color: white;
            padding: 160px 0 100px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="rgba(255,255,255,0.1)"></path></svg>');
            background-size: cover;
            background-position: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .hero-content h1 {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.9) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-accent {
            background: linear-gradient(135deg, var(--gh-accent), #e0a800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-lead {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
            line-height: 1.6;
            max-width: 600px;
        }

        .btn-hero {
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            border: 2px solid transparent;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--gh-accent), #e0a800);
            color: #000;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
            color: #000;
        }

        .btn-hero-outline {
            background: transparent;
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-hero-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            color: white;
            transform: translateY(-3px);
        }

        /* Modern Services Section */
        .services-section {
            padding: 100px 0;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--gh-dark);
            margin-bottom: 1rem;
            position: relative;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border-radius: 2px;
        }

        .section-title p {
            font-size: 1.125rem;
            color: var(--gh-text-light);
            max-width: 600px;
            margin: 1.5rem auto 0;
        }

        .service-card {
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 16px;
            text-align: center;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--gh-primary);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .service-card h4 {
            font-weight: 600;
            color: var(--gh-dark);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .service-card p {
            color: var(--gh-text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .service-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gh-primary);
            margin-bottom: 1.5rem;
        }

        .btn-service {
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-service:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            color: white;
        }

        /* Enhanced About Section */
        .about-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .about-content {
            padding-right: 3rem;
        }

        .about-image {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .about-image i {
            font-size: 4rem;
            opacity: 0.8;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 2rem 0;
        }

        .feature-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            color: var(--gh-text);
        }

        .feature-list i {
            color: var(--gh-primary);
            margin-right: 12px;
            font-size: 1.2rem;
            background: rgba(16, 185, 129, 0.1);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--gh-dark), #111827);
            color: white;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--gh-primary);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 1.125rem;
            color: #d1d5db;
            font-weight: 500;
        }

        /* Modern Testimonials */
        .testimonials-section {
            padding: 100px 0;
            background: white;
        }

        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin: 1rem;
            height: 100%;
            position: relative;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 4rem;
            color: rgba(16, 185, 129, 0.1);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .testimonial-text {
            font-style: italic;
            color: var(--gh-text-light);
            margin-bottom: 2rem;
            line-height: 1.6;
            font-size: 1.05rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        .author-info h5 {
            margin: 0;
            font-weight: 600;
            color: var(--gh-dark);
        }

        .author-info p {
            margin: 0;
            color: var(--gh-text-light);
            font-size: 0.9rem;
        }

        /* Modern CTA Section */
        .cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--gh-primary), var(--gh-primary-dark));
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="rgba(255,255,255,0.1)"></path></svg>');
            background-size: cover;
            background-position: center;
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-content h3 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .cta-content p {
            opacity: 0.9;
            font-size: 1.25rem;
            max-width: 600px;
            margin: 0 auto 3rem;
            line-height: 1.6;
        }

        /* Modern Footer */
        .footer {
            background: var(--gh-dark);
            color: #9ca3af;
            padding: 80px 0 30px;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .footer-text {
            line-height: 1.6;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .footer-links h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #9ca3af;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-links a:hover {
            color: var(--gh-primary);
            transform: translateX(5px);
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: #6b7280;
            font-size: 0.9rem;
        }

        /* Animation classes */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 140px 0 80px;
                text-align: center;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-lead {
                font-size: 1.125rem;
            }

            .services-section, .about-section, .testimonials-section, .cta-section {
                padding: 60px 0;
            }

            .about-content {
                padding-right: 0;
                margin-bottom: 3rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .btn-hero {
                width: 100%;
                max-width: 300px;
                justify-content: center;
                margin: 0.5rem 0;
            }

            .service-card {
                padding: 2rem 1.5rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-badge {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }

            .section-title h2 {
                font-size: 1.75rem;
            }

            .service-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .cta-content h3 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Modern Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="brand-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                GreenHome Pest Control
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link admin-login" href="{{ route('login') }}">
                            <i class="fas fa-user-shield me-2"></i> Admin Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Enhanced Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-content fade-in-up">
                        <span class="hero-badge">
                            <i class="fas fa-shield-alt me-2"></i>Professional Pest Management Since 2008
                        </span>
                        <h1>
                            Pest-Free Living<br>
                            <span class="hero-accent">Guaranteed</span>
                        </h1>
                        <p class="hero-lead">
                            We provide effective, eco-friendly pest control solutions to protect your home and family.
                            Our expert technicians use the latest methods to eliminate pests and prevent future infestations.
                        </p>
                        <div class="hero-buttons">
                            <a href="#services" class="btn btn-hero btn-hero-primary">
                                <i class="fas fa-clipboard-list me-2"></i>Our Services
                            </a>
                            <a href="tel:+15551234567" class="btn btn-hero btn-hero-outline">
                                <i class="fas fa-phone me-2"></i> Call Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in-up">
                        <div class="stat-number">2,500+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.1s;">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.2s;">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Emergency Service</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item fade-in-up" style="animation-delay: 0.3s;">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Satisfaction Guarantee</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Services Section -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="section-title fade-in-up">
                <h2>Our Professional Services</h2>
                <p>Comprehensive pest control solutions tailored to your specific needs</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card fade-in-up">
                        <div class="service-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h4>Residential Pest Control</h4>
                        <p>Complete protection for your home against common pests with our safe, family-friendly treatments and preventive solutions.</p>
                        <div class="service-price">From $99</div>
                        <a href="#contact" class="btn btn-service">
                            <i class="fas fa-calendar-check me-2"></i>Schedule Service
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card fade-in-up" style="animation-delay: 0.1s;">
                        <div class="service-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4>Commercial Solutions</h4>
                        <p>Customized pest management programs for businesses, restaurants, and commercial properties with compliance guarantees.</p>
                        <div class="service-price">Custom Quote</div>
                        <a href="#contact" class="btn btn-service">
                            <i class="fas fa-briefcase me-2"></i>Business Inquiry
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card fade-in-up" style="animation-delay: 0.2s;">
                        <div class="service-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Termite Protection</h4>
                        <p>Advanced termite detection and elimination services with long-term protection plans and damage warranties.</p>
                        <div class="service-price">From $299</div>
                        <a href="#contact" class="btn btn-service">
                            <i class="fas fa-search me-2"></i>Free Inspection
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content fade-in-up">
                        <div class="section-title text-start">
                            <h2>Why Choose GreenHome?</h2>
                            <p class="mt-3">Experience the difference with our professional approach</p>
                        </div>
                        <p class="mb-4 fs-5">
                            With over 15 years of experience, GreenHome Pest Control combines cutting-edge technology
                            with environmentally responsible practices to deliver exceptional results you can trust.
                        </p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Licensed & Certified Technicians</li>
                            <li><i class="fas fa-check"></i> Eco-Friendly Treatment Options</li>
                            <li><i class="fas fa-check"></i> Same-Day Emergency Service</li>
                            <li><i class="fas fa-check"></i> 100% Satisfaction Guarantee</li>
                            <li><i class="fas fa-check"></i> Free Inspections & Estimates</li>
                            <li><i class="fas fa-check"></i> Pet & Family Safe Solutions</li>
                        </ul>
                        <a href="#contact" class="btn btn-service btn-lg mt-3">
                            <i class="fas fa-phone me-2"></i>Contact Us Today
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image fade-in-up" style="animation-delay: 0.2s;">
                        <i class="fas fa-award"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-title fade-in-up">
                <h2>Trusted by Our Customers</h2>
                <p>See what homeowners and businesses are saying about our services</p>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-card fade-in-up">
                        <div class="testimonial-text">
                            "GreenHome eliminated our ant problem in just one treatment. The technician was professional, knowledgeable, and took the time to explain everything. Highly recommend their services!"
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">SJ</div>
                            <div class="author-info">
                                <h5>Sarah Johnson</h5>
                                <p>Homeowner, 5 years with GreenHome</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card fade-in-up" style="animation-delay: 0.1s;">
                        <div class="testimonial-text">
                            "As a restaurant owner, pest control is critical to our business. GreenHome has kept our establishment pest-free for 3 years now. Their commercial program is excellent and reliable."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">MR</div>
                            <div class="author-info">
                                <h5>Michael Rodriguez</h5>
                                <p>Restaurant Owner</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card fade-in-up" style="animation-delay: 0.2s;">
                        <div class="testimonial-text">
                            "We had a serious bed bug issue that other companies couldn't solve. GreenHome came in with a comprehensive plan and eliminated them completely. Professional service worth every penny!"
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">TW</div>
                            <div class="author-info">
                                <h5>Thomas Wilson</h5>
                                <p>Apartment Complex Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced CTA Section -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-content fade-in-up">
                <h3>Ready for a Pest-Free Environment?</h3>
                <p>Contact us today for a free inspection and estimate. Our expert team is ready to help you reclaim your space from unwanted pests with guaranteed results.</p>
                <a href="tel:+15551234567" class="btn btn-hero btn-hero-primary me-3">
                    <i class="fas fa-phone me-2"></i> Call Now
                </a>
                <a href="mailto:info@greenhomepest.com" class="btn btn-hero btn-hero-outline">
                    <i class="fas fa-envelope me-2"></i> Email Us
                </a>
            </div>
        </div>
    </section>

    <!-- Enhanced Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">
                        <i class="fas fa-leaf"></i>
                        GreenHome Pest Control
                    </div>
                    <p class="footer-text">
                        Professional pest control services with a focus on effectiveness, safety, and environmental responsibility.
                        Serving residential and commercial clients with excellence since 2008.
                    </p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Services</h5>
                        <ul>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Residential</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Commercial</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Termite Control</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Emergency Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="#home"><i class="fas fa-chevron-right"></i> Home</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Services</a></li>
                            <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                            <li><a href="#testimonials"><i class="fas fa-chevron-right"></i> Testimonials</a></li>
                            <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Admin Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Contact Info</h5>
                        <ul>
                            <li><a href="tel:+15551234567"><i class="fas fa-phone"></i> +1 (555) 123-4567</a></li>
                            <li><a href="mailto:info@greenhomepest.com"><i class="fas fa-envelope"></i> info@greenhomepest.com</a></li>
                            <li><a href="#"><i class="fas fa-map-marker-alt"></i> 123 Pest Control Ave</a></li>
                            <li><a href="#"><i class="fas fa-clock"></i> Mon-Fri: 8am-6pm</a></li>
                            <li><a href="#"><i class="fas fa-clock"></i> Sat: 9am-4pm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 GreenHome Pest Control. All rights reserved. | Professional Pest Management Services</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });

            // Scroll animation for elements
            const fadeElements = document.querySelectorAll('.fade-in-up');

            const fadeInOnScroll = function() {
                fadeElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;

                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('visible');
                    }
                });
            };

            // Check on load and scroll
            fadeInOnScroll();
            window.addEventListener('scroll', fadeInOnScroll);

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });

                        // Update active nav link
                        document.querySelectorAll('.nav-link').forEach(link => {
                            link.classList.remove('active');
                        });
                        this.classList.add('active');
                    }
                });
            });

            // Add loading animation to elements
            const cards = document.querySelectorAll('.service-card, .testimonial-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
