<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkyConnect - Flight Reservation')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/iphone-theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
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
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg fixed-top shadow-none" id="mirrorNav">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-plane-departure brand-icon me-2" style="font-size: 1.8rem;"></i>
                <span class="fw-800" style="letter-spacing: -1.5px;">SkyConnect</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars-staggered"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            Explore
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flights.*') ? 'active' : '' }}" href="{{ route('flights.searchForm') }}">
                            Book
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('my-bookings.index') ? 'active' : '' }}" href="{{ route('my-bookings.index') }}">
                                My Trips
                            </a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav align-items-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link user-nav-item dropdown-toggle border-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <div class="user-nav-avatar shadow-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                <span class="d-none d-lg-inline fw-bold" id="userNameText">{{ Auth::user()->name }}</span>
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
                            <a class="nav-link px-4" href="{{ route('login') }}">Sign In</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link btn btn-primary text-white" href="{{ route('register') }}" style="padding: 10px 25px !important; border-radius: 50px;">Join Now</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 20px; background: rgba(52, 199, 89, 0.15); backdrop-filter: blur(10px);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3 fa-lg text-success"></i>
                    <div class="fw-bold">{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 20px; background: rgba(255, 59, 48, 0.15); backdrop-filter: blur(10px);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-3 fa-lg text-danger"></i>
                    <div class="fw-bold">{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- PREMIUM CORPORATE FOOTER -->
    <footer class="py-5 mt-5" style="background: #1c1c1e; color: white;">
        <div class="container py-4">
            <div class="row g-5 text-center text-md-start">
                <div class="col-lg-4">
                    <a class="navbar-brand d-flex align-items-center mb-4" href="#">
                        <i class="fas fa-plane-departure text-primary me-2"></i>
                        <span class="fw-800 text-white" style="letter-spacing: -1px;">SkyConnect</span>
                    </a>
                    <p class="text-secondary small pe-lg-5 mb-4">Redefining boutique air travel with curated routes and luxury experiences for the discerning traveler. Experience the art of flight.</p>
                    <div class="social-links d-flex justify-content-center justify-content-md-start gap-3">
                        <a href="#" class="text-white opacity-50"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white opacity-50"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white opacity-50"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-4 text-white">Company</h6>
                    <a href="#" class="footer-link">About Us</a>
                    <a href="#" class="footer-link">Our Fleet</a>
                    <a href="#" class="footer-link">Destinations</a>
                    <a href="#" class="footer-link">Careers</a>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-4 text-white">Support</h6>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Flight Status</a>
                    <a href="#" class="footer-link">Refund Policy</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-4 text-white">Newsletter</h6>
                    <p class="text-secondary small mb-4">Subscribe for exclusive travel offers and global destination updates.</p>
                    <div class="input-group">
                        <input type="text" class="form-control bg-dark border-0 text-white rounded-start-pill px-4" placeholder="Email Address">
                        <button class="btn btn-primary rounded-end-pill px-4">Join</button>
                    </div>
                </div>
            </div>
            <div class="border-top border-white border-opacity-10 mt-5 pt-4 text-center">
                <p class="text-secondary small mb-0" style="font-size: 0.75rem;">&copy; {{ date('Y') }} SkyConnect Aviation Group. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.getElementById('mirrorNav');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 30) {
                    nav.classList.add('scrolled');
                    nav.style.margin = '0';
                    nav.style.borderRadius = '0';
                } else {
                    nav.classList.remove('scrolled');
                    nav.style.margin = '15px 20px';
                    nav.style.borderRadius = '100px';
                }
            });
        });
    </script>
</body>
</html>