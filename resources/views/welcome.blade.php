<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyConnect | Experience the Future of Flight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/iphone-theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Reset for full-screen hero */
        body {
            margin: 0 !important;
            padding-top: 0 !important;
        }

        .hero-section {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: url('https://wallpaperaccess.com/full/896979.jpg') no-repeat center center;
            background-size: cover;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.2) 100%);
            z-index: 1;
        }

        .hero-content-container {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 0 5%;
            animation: slideInUp 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .hero-text-side h1 {
            color: white !important;
            font-weight: 800;
            font-size: 4rem;
            line-height: 1.1;
            margin-bottom: 25px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .hero-text-side p {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 1.25rem;
            font-weight: 400;
            max-width: 600px;
            margin-bottom: 40px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .badge-premium {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 20px;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
            border-radius: 50px;
            margin-bottom: 30px;
            display: inline-block;
        }

        .premium-text-gradient {
            background: linear-gradient(135deg, #fff 0%, #007aff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Nav transparency at top */
        .navbar {
            background: transparent !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            border-bottom: none !important;
            box-shadow: none !important;
            margin: 0 !important;
            border-radius: 0 !important;
            padding: 25px 0 !important;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07) !important;
            padding: 10px 0 !important;
        }

        .user-nav-item {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            padding: 6px 18px 6px 6px !important;
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 50px !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            text-decoration: none !important;
        }

        .navbar.scrolled .user-nav-item {
            background: rgba(0, 0, 0, 0.05) !important;
            border-color: rgba(0, 0, 0, 0.1) !important;
        }

        .user-nav-avatar {
            width: 32px;
            height: 32px;
            background: var(--sc-primary);
            color: white;
            border-radius: 50%;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 700;
            font-size: 0.8rem;
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .destination-card {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            border: none;
            overflow: hidden;
            border-radius: 24px;
        }

        .destination-card:hover {
            transform: scale(1.03) translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .service-icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: rgba(0, 122, 255, 0.1);
            color: var(--sc-primary);
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .footer-link {
            color: var(--sc-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            display: block;
            margin-bottom: 10px;
        }

        .footer-link:hover {
            color: var(--sc-primary);
            transform: translateX(5px);
        }

        @media (max-width: 991px) {
            .hero-text-side h1 { font-size: 3rem; }
            .hero-content-container { text-align: center; }
            .hero-action-side { margin-top: 40px; }
            .hero-overlay { background: rgba(0,0,0,0.4); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-plane-departure brand-icon me-2 text-white" id="brandIcon" style="font-size: 1.8rem;"></i>
                <span class="fw-800 text-white" id="brandText" style="letter-spacing: -1.5px;">SkyConnect</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars-staggered text-white" id="navToggler"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-auto" id="centerNav" style="opacity: 0; visibility: hidden; max-width: 60%;">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="{{ route('home') }}">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="{{ route('flights.searchForm') }}">Book</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="{{ route('my-bookings.index') }}">My Trips</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav align-items-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link user-nav-item dropdown-toggle border-0 shadow-sm" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="user-nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                <span class="d-none d-lg-inline text-white fw-bold" id="userNameText">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3" style="border-radius: 24px; padding: 12px; background: rgba(255,255,255,0.9); backdrop-filter: blur(20px);">
                                <li><a class="dropdown-item py-2 px-4 rounded-pill mb-1" href="{{ route('profile.edit') }}"><i class="fas fa-user-circle me-2 text-primary"></i>Profile</a></li>
                                <li><a class="dropdown-item py-2 px-4 rounded-pill mb-1" href="{{ route('my-bookings.index') }}"><i class="fas fa-history me-2 text-primary"></i>History</a></li>
                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'employee')
                                    <li><hr class="dropdown-divider mx-3"></li>
                                    <li><a class="dropdown-item py-2 px-4 rounded-pill mb-1 fw-bold text-primary" href="{{ route('admin.dashboard') }}"><i class="fas fa-user-shield me-2"></i>Staff Portal</a></li>
                                @endif
                                <li><hr class="dropdown-divider mx-3"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 px-4 rounded-pill text-danger"><i class="fas fa-sign-out-alt me-2"></i>Sign Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link px-4 text-white fw-bold" href="{{ route('login') }}" id="loginLink">Sign In</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link btn btn-primary text-white shadow-sm" href="{{ route('register') }}" style="padding: 12px 30px !important; border-radius: 50px; font-weight: 700;">Join Now</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container-fluid hero-content-container">
            <div class="row align-items-center">
                <div class="col-lg-8 hero-text-side">
                    <div class="badge-premium">The New Standard of Travel</div>
                    <h1 class="display-1">Sky Without <br><span class="premium-text-gradient">Limits.</span></h1>
                    <p class="lead mb-5">
                        Experience luxury redefined. From seamless booking to world-class arrivals, SkyConnect is your exclusive gateway to the world's most breathtaking destinations.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="{{ route('flights.searchForm') }}" class="btn btn-primary btn-lg px-5 py-3 shadow-lg" style="font-size: 1.1rem; min-width: 250px;">
                            <i class="fas fa-search me-2"></i> Find Your Flight
                        </a>
                        <a href="#explore" class="btn btn-outline-light btn-lg px-5 py-3" style="font-size: 1.1rem; border-width: 2px; min-width: 250px;">
                            Explore Destinations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Destination Explorer -->
    <section id="explore" class="container py-5 mt-5">
        <div class="text-center mb-5 reveal">
            <h6 class="text-primary fw-bold text-uppercase mb-2" style="letter-spacing: 3px;">Global Curations</h6>
            <h2 class="display-5 fw-bold text-dark mb-3">Explore the World</h2>
            <p class="lead text-muted mx-auto" style="max-width: 600px;">Hand-picked destinations offering unique experiences and unforgettable memories.</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4 reveal">
                <div class="card destination-card h-100">
                    <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Tokyo" style="height: 250px; object-fit: cover;">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold mb-2">Tokyo</h4>
                        <p class="text-muted small mb-4">Where ancient traditions meet neon-lit futuristic streets.</p>
                        <a href="{{ route('flights.searchForm') }}" class="btn btn-outline-primary rounded-pill px-4">Find Flights</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 reveal">
                <div class="card destination-card h-100">
                    <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Paris" style="height: 250px; object-fit: cover;">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold mb-2">Paris</h4>
                        <p class="text-muted small mb-4">The timeless capital of art, gastronomy, and romance.</p>
                        <a href="{{ route('flights.searchForm') }}" class="btn btn-outline-primary rounded-pill px-4">Find Flights</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 reveal">
                <div class="card destination-card h-100">
                    <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Dubai" style="height: 250px; object-fit: cover;">
                    <div class="card-body p-4 text-center">
                        <h4 class="fw-bold mb-2">Dubai</h4>
                        <p class="text-muted small mb-4">An oasis of luxury and architectural marvels in the desert.</p>
                        <a href="{{ route('flights.searchForm') }}" class="btn btn-outline-primary rounded-pill px-4">Find Flights</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar - MOVED DOWN -->
    <section class="container py-5 my-5">
        <div class="card p-5 border-0 shadow-lg text-center reveal">
            <div class="row">
                <div class="col-md-3 col-6 border-end">
                    <h2 class="fw-800 text-primary mb-0">120+</h2>
                    <p class="text-secondary small fw-bold mb-0">DESTINATIONS</p>
                </div>
                <div class="col-md-3 col-6 border-end">
                    <h2 class="fw-800 text-primary mb-0">450k</h2>
                    <p class="text-secondary small fw-bold mb-0">PASSENGERS</p>
                </div>
                <div class="col-md-3 col-6 border-end">
                    <h2 class="fw-800 text-primary mb-0">15M+</h2>
                    <p class="text-secondary small fw-bold mb-0">MILES FLOWN</p>
                </div>
                <div class="col-md-3 col-6">
                    <h2 class="fw-800 text-primary mb-0">24/7</h2>
                    <p class="text-secondary small fw-bold mb-0">CONCIERGE</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Luxury Services Section -->
    <section class="container-fluid py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5 reveal">
                    <h6 class="text-primary fw-bold text-uppercase mb-2" style="letter-spacing: 3px;">The Experience</h6>
                    <h2 class="display-5 fw-bold text-dark mb-4">Beyond Flight. <br>Refined Luxury.</h2>
                    <p class="text-muted mb-5 lead">We believe the journey should be as magnificent as the destination. That's why SkyConnect offers an unparalleled suite of services designed for the modern elite traveler.</p>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="service-icon-box"><i class="fas fa-utensils"></i></div>
                            <h6 class="fw-bold">Elite Dining</h6>
                            <p class="small text-secondary">Michelin-star inspired menus crafted for the skies.</p>
                        </div>
                        <div class="col-md-6">
                            <div class="service-icon-box"><i class="fas fa-couch"></i></div>
                            <h6 class="fw-bold">Global Lounges</h6>
                            <p class="small text-secondary">Exclusive access to premier private lounges worldwide.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1 reveal">
                    <img src="https://images.unsplash.com/photo-1569154941061-e231b4725ef1?auto=format&fit=crop&w=1000&q=80" class="img-fluid rounded-4 shadow-lg mt-5 mt-lg-0" alt="Luxury Lounge">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="container py-5 my-5">
        <div class="text-center mb-5 reveal">
            <h6 class="text-primary fw-bold text-uppercase mb-2" style="letter-spacing: 3px;">Members Voice</h6>
            <h2 class="display-5 fw-bold text-dark">The SkyConnect Way</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 reveal">
                <div class="card p-4 h-100">
                    <div class="text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-dark fw-500 italic">"The most seamless booking experience I've ever had. The mirror design is intuitive and truly first-class."</p>
                    <div class="d-flex align-items-center mt-4 pt-3 border-top">
                        <div class="avatar-circle me-3" style="width: 40px; height: 40px; font-size: 0.8rem;">JS</div>
                        <div>
                            <h6 class="mb-0 fw-bold">James Sterling</h6>
                            <p class="small text-secondary mb-0">Global Executive</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal">
                <div class="card p-4 h-100">
                    <div class="text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-dark fw-500 italic">"SkyConnect turns regular travel into an event. The concierge service is exceptionally helpful."</p>
                    <div class="d-flex align-items-center mt-4 pt-3 border-top">
                        <div class="avatar-circle me-3" style="width: 40px; height: 40px; font-size: 0.8rem;">EV</div>
                        <div>
                            <h6 class="mb-0 fw-bold">Elena Vance</h6>
                            <p class="small text-secondary mb-0">Creative Director</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal">
                <div class="card p-4 h-100">
                    <div class="text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-dark fw-500 italic">"From the digital boarding pass to the seat selection, everything feels like the future of aviation."</p>
                    <div class="d-flex align-items-center mt-4 pt-3 border-top">
                        <div class="avatar-circle me-3" style="width: 40px; height: 40px; font-size: 0.8rem;">MK</div>
                        <div>
                            <h6 class="mb-0 fw-bold">Marcus Kane</h6>
                            <p class="small text-secondary mb-0">Tech Founder</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pre-Footer Premium CTA -->
    <section class="container py-5">
        <div class="card bg-primary p-5 text-center text-white border-0 shadow-lg reveal" style="background: linear-gradient(135deg, var(--sc-primary) 0%, #5856d6 100%) !important;">
            <h2 class="display-4 fw-800 mb-3">Ready for Takeoff?</h2>
            <p class="lead mb-5 opacity-90">Join thousands of travelers who have chosen the standard of excellence.</p>
            <div class="d-flex justify-content-center">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-800 text-primary">Create Your Account</a>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.getElementById('mainNav');
            const brandText = document.getElementById('brandText');
            const brandIcon = document.getElementById('brandIcon');
            const navToggler = document.getElementById('navToggler');
            const userNameText = document.getElementById('userNameText');
            const loginLink = document.getElementById('loginLink');
            const centerNav = document.getElementById('centerNav');
            const navLinks = document.querySelectorAll('.nav-link');

            function updateNav() {
                if (window.scrollY > 50) {
                    nav.classList.add('scrolled');
                    brandText.style.setProperty('color', '#1c1c1e', 'important');
                    brandIcon.style.setProperty('color', '#007aff', 'important');
                    if(navToggler) navToggler.style.setProperty('color', '#1c1c1e', 'important');
                    if(userNameText) userNameText.style.setProperty('color', '#1c1c1e', 'important');
                    if(loginLink) loginLink.style.setProperty('color', '#1c1c1e', 'important');

                    if(centerNav) {
                        centerNav.style.opacity = '1';
                        centerNav.style.visibility = 'visible';
                    }
                    navLinks.forEach(link => {
                        if (!link.classList.contains('dropdown-toggle') && !link.classList.contains('btn')) {
                            link.style.setProperty('color', '#1c1c1e', 'important');
                        }
                    });
                } else {
                    nav.classList.remove('scrolled');
                    brandText.style.setProperty('color', '#ffffff', 'important');
                    brandIcon.style.setProperty('color', '#ffffff', 'important');
                    if(navToggler) navToggler.style.setProperty('color', '#ffffff', 'important');
                    if(userNameText) userNameText.style.setProperty('color', '#ffffff', 'important');
                    if(loginLink) loginLink.style.setProperty('color', '#ffffff', 'important');

                    if(centerNav) {
                        centerNav.style.opacity = '0';
                        centerNav.style.visibility = 'hidden';
                    }
                    navLinks.forEach(link => {
                        if (!link.classList.contains('dropdown-toggle') && !link.classList.contains('btn')) {
                            link.style.setProperty('color', '#ffffff', 'important');
                        }
                    });
                }
            }

            window.addEventListener('scroll', updateNav);
            updateNav();

            function reveal() {
                var reveals = document.querySelectorAll(".reveal");
                for (var i = 0; i < reveals.length; i++) {
                    var windowHeight = window.innerHeight;
                    var elementTop = reveals[i].getBoundingClientRect().top;
                    var elementVisible = 150;
                    if (elementTop < windowHeight - elementVisible) {
                        reveals[i].classList.add("active");
                    }
                }
            }
            window.addEventListener("scroll", reveal);
            reveal();
        });
    </script>
</body>
</html>
