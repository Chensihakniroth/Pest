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
            --accent: #ffc107;
            --dark: #2c3e50;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            overflow-x: hidden;
            background: #fafbfc;
        }

        /* Modern Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--dark) !important;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-green);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: white;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(25, 135, 84, 0.1);
            color: var(--primary-green) !important;
            transform: translateY(-1px);
        }

        .admin-login {
            background: var(--primary-green);
            color: white !important;
            border-radius: 8px;
            padding: 0.6rem 1.5rem !important;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-green);
        }

        .admin-login:hover {
            background: transparent;
            color: var(--primary-green) !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
        }

        /* Enhanced Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            padding: 180px 0 120px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.03" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,192C1248,192,1344,128,1392,96L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 2rem;
            letter-spacing: 0.5px;
        }

        .hero-content h1 {
            font-weight: 800;
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .text-accent {
            background: linear-gradient(135deg, var(--accent) 0%, #e0a800 100%);
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
            margin-left: auto;
            margin-right: auto;
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
            border: 2px solid transparent;
            margin: 0 0.5rem 1rem;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, var(--accent) 0%, #e0a800 100%);
            color: #000;
            border-color: var(--accent);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.3);
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
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--dark);
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
            background: var(--primary-green);
            border-radius: 2px;
        }

        .section-title p {
            font-size: 1.125rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        .service-card {
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 16px;
            text-align: center;
            height: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e9ecef;
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
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-green);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
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
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .service-card p {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .service-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 1.5rem;
        }

        .btn-service {
            background: var(--primary-green);
            color: white;
            border: 2px solid var(--primary-green);
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-service:hover {
            background: transparent;
            color: var(--primary-green);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
        }

        /* Enhanced About Section */
        .about-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .about-content {
            padding-right: 2rem;
        }

        .about-image {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
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
        }

        .feature-list i {
            color: var(--primary-green);
            margin-right: 12px;
            font-size: 1.2rem;
            background: var(--light-green);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
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
            border: 1px solid #f1f3f4;
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
            color: var(--light-green);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .testimonial-text {
            font-style: italic;
            color: #6c757d;
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
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
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
            color: var(--dark);
        }

        .author-info p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Modern CTA Section */
        .cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            text-align: center;
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
            background: var(--dark);
            color: #adb5bd;
            padding: 80px 0 30px;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .footer-brand i {
            margin-right: 12px;
            color: var(--primary-green);
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
            color: #adb5bd;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer-links a i {
            margin-right: 8px;
            width: 16px;
        }

        .footer-bottom {
            border-top: 1px solid #343a40;
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: #6c757d;
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
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
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
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center hero-content fade-in-up">
                    <span class="hero-badge">
                        <i class="fas fa-shield-alt me-2"></i>Professional Pest Management
                    </span>
                    <h1 class="display-4 fw-bold">
                        Pest-Free Living<br>
                        <span class="text-accent">Guaranteed</span>
                    </h1>
                    <p class="hero-lead">
                        We provide effective, eco-friendly pest control solutions to protect your home and family.
                        Our expert technicians use the latest methods to eliminate pests and prevent future infestations.
                    </p>
                    <div class="hero-buttons">
                        <a href="#services" class="btn btn-hero btn-hero-primary">
                            Our Services <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#contact" class="btn btn-hero btn-hero-outline">
                            <i class="fas fa-phone me-2"></i> Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Services Section -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="section-title fade-in-up">
                <h2>Our Pest Control Services</h2>
                <p>Comprehensive solutions for all your pest problems with guaranteed results</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card fade-in-up">
                        <div class="service-icon">
                            <i class="fas fa-bug"></i>
                        </div>
                        <h4>Residential Pest Control</h4>
                        <p>Protect your home from common pests like ants, roaches, spiders, and rodents with our safe and effective treatments.</p>
                        <div class="service-price">From $99</div>
                        <a href="#contact" class="btn btn-service">Get Quote</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card fade-in-up" style="animation-delay: 0.1s;">
                        <div class="service-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4>Commercial Pest Control</h4>
                        <p>Keep your business pest-free with our customized commercial solutions that meet industry standards and regulations.</p>
                        <div class="service-price">Custom Quote</div>
                        <a href="#contact" class="btn btn-service">Get Quote</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card fade-in-up" style="animation-delay: 0.2s;">
                        <div class="service-icon">
                            <i class="fas fa-mosquito"></i>
                        </div>
                        <h4>Mosquito Control</h4>
                        <p>Enjoy your outdoor spaces with our effective mosquito control treatments that reduce populations by up to 90%.</p>
                        <div class="service-price">From $79</div>
                        <a href="#contact" class="btn btn-service">Get Quote</a>
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
                        </div>
                        <p class="mb-4 fs-5">
                            With over 15 years of experience in the pest control industry, GreenHome Pest Control has established
                            itself as a trusted provider of effective and environmentally responsible pest management solutions.
                        </p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Licensed and certified technicians</li>
                            <li><i class="fas fa-check"></i> Eco-friendly treatment options</li>
                            <li><i class="fas fa-check"></i> Same-day emergency service available</li>
                            <li><i class="fas fa-check"></i> 100% satisfaction guarantee</li>
                            <li><i class="fas fa-check"></i> Free inspections and estimates</li>
                            <li><i class="fas fa-check"></i> Pet and family-safe treatments</li>
                        </ul>
                        <a href="#contact" class="btn btn-service btn-lg mt-3">Contact Us Today</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image fade-in-up" style="animation-delay: 0.2s;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="section-title fade-in-up">
                <h2>What Our Customers Say</h2>
                <p>Don't just take our word for it - hear from our satisfied customers</p>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-card fade-in-up">
                        <div class="testimonial-text">
                            "GreenHome eliminated our ant problem in just one treatment. The technician was professional, knowledgeable, and took the time to explain everything. Highly recommend!"
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
                            "As a restaurant owner, pest control is critical to our business. GreenHome has kept our establishment pest-free for 3 years now. Their commercial program is excellent."
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
                            "We had a serious bed bug issue that other companies couldn't solve. GreenHome came in with a comprehensive plan and eliminated them completely. Worth every penny!"
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
                <h3>Ready for a Pest-Free Home?</h3>
                <p>Contact us today for a free inspection and estimate. Our team is ready to help you reclaim your space from unwanted pests.</p>
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
                        Serving residential and commercial clients for over 15 years.
                    </p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Services</h5>
                        <ul>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Residential</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Commercial</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Mosquito Control</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Termite Treatment</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="#services"><i class="fas fa-chevron-right"></i> Services</a></li>
                            <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                            <li><a href="#testimonials"><i class="fas fa-chevron-right"></i> Testimonials</a></li>
                            <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
                            <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Admin Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="footer-links">
                        <h5>Contact</h5>
                        <ul>
                            <li><a href="mailto:info@greenhomepest.com"><i class="fas fa-envelope"></i> info@greenhomepest.com</a></li>
                            <li><a href="tel:+15551234567"><i class="fas fa-phone"></i> +1 (555) 123-4567</a></li>
                            <li><a href="#"><i class="fas fa-map-marker-alt"></i> 123 Pest Control Ave</a></li>
                            <li><a href="#"><i class="fas fa-clock"></i> Mon-Fri: 8am-6pm</a></li>
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
                    navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                    navbar.style.boxShadow = '0 2px 30px rgba(0, 0, 0, 0.1)';
                } else {
                    navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                    navbar.style.boxShadow = '0 2px 30px rgba(0, 0, 0, 0.08)';
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
                    }
                });
            });
        });
    </script>
</body>
</html>
