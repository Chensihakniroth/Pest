<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenHome Pest Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Enhanced Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 0.8rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand i {
            font-size: 1.8rem;
            background: rgba(255,255,255,0.2);
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover i {
            background: rgba(255,255,255,0.3);
            transform: scale(1.1);
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.8rem 1.2rem !important;
            margin: 0 2px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            color: rgba(255,255,255,0.9) !important;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.15);
            color: white !important;
            transform: translateY(-1px);
        }
        
        .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white !important;
        }
        
        .nav-link i {
            margin-right: 8px;
            font-size: 1.1rem;
        }
        
        .logout-btn {
            background: rgba(255,255,255,0.1) !important;
            border: 1px solid rgba(255,255,255,0.3) !important;
            border-radius: 8px;
            padding: 0.5rem 1rem !important;
            margin-left: 10px;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.2) !important;
            border-color: rgba(255,255,255,0.5) !important;
            transform: translateY(-1px);
        }
        
        /* Layout fixes */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        main {
            flex: 1;
            padding-bottom: 2rem;
        }
        
        /* Footer Styles */
        .main-footer {
            background: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: auto;
            border-top: 3px solid #198754;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer-brand {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .footer-brand i {
            color: #198754;
            margin-right: 8px;
        }
        
        .footer-text {
            color: #adb5bd;
            margin-bottom: 0.5rem;
        }
        
        .footer-copyright {
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid #495057;
            padding-top: 1rem;
            margin-top: 1rem;
        }
        
      
        /* Mobile responsive */
        @media (max-width: 768px) {
        .footer-content {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
        }
            
            .nav-link {
                margin: 5px 0;
                text-align: center;
            }
            
            .logout-btn {
                margin: 10px 0 0 0;
                text-align: center;
                width: 100%;
            }
        }

/* Clean Modern Pagination */
.pagination-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}

.pagination {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.pagination .page-item {
    margin: 0;
}

.pagination .page-link {
    padding: 10px 16px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    color: #495057;
    font-weight: 500;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 45px;
    height: 45px;
    text-decoration: none;
    background-color: white;
}

.pagination .page-link:hover {
    background-color: #198754;
    color: white;
    border-color: #198754;
}

.pagination .page-item.active .page-link {
    background-color: #198754;
    border-color: #198754;
    color: white;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(25, 135, 84, 0.3);
}

.pagination .page-item.disabled .page-link {
    opacity: 0.4;
    cursor: not-allowed;
    background-color: #f8f9fa;
    color: #6c757d;
}

.pagination .page-item.disabled .page-link:hover {
    background-color: #f8f9fa;
    color: #6c757d;
    border-color: #dee2e6;
}

/* Arrow buttons */
.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    font-size: 18px;
    padding: 10px 14px;
}

/* Results text styling */
.pagination-info {
    color: #6c757d;
    font-size: 0.95rem;
}

@media (max-width: 576px) {
    .pagination-wrapper {
        flex-direction: column;
        gap: 10px;
    }
    
    .pagination .page-link {
        padding: 8px 12px;
        min-width: 40px;
        height: 40px;
        font-size: 0.9rem;
    }
}

    /* Loading spinner animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fa-spin {
    animation: spin 1s linear infinite;
}

/* Smooth fade for table updates */
#customersTableContainer {
    transition: opacity 0.2s ease;
}

/* Clear button hover effect */
#clearSearch:hover {
    background-color: #dc3545 !important;
    color: white !important;
    border-color: #dc3545 !important;
}
    </style>
</head>
<body>
    <!-- Enhanced Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-home"></i>
                GreenHome Pest Control
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-center">
                    @auth
                        <!-- Dashboard -->
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                           href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line"></i>Dashboard
                        </a>
                        
                        <!-- Customers -->
                        <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" 
                           href="{{ route('customers.index') }}">
                            <i class="fas fa-users"></i>Customers
                        </a>
                        
                        <!-- Profile -->
                        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" 
                           href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-circle"></i>Profile
                        </a>
                        
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link logout-btn border-0">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </button>
                        </form>
                    @else
                        <!-- Login -->
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i>Login
                        </a>
                        
                        <!-- Register -->
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i>Register
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

<!-- Modern Slim Footer -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <i class="fas fa-home"></i>
                <span>GreenHome Pest Control</span>
            </div>
            <p class="footer-text">Professional pest control & customer management</p>
            <div class="footer-copyright">
                &copy; {{ date('Y') }} GreenHome. All rights reserved.
            </div>
        </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add active state management
        document.addEventListener('DOMContentLoaded', function() {
            // Remove blinking cursor from navbar elements
            const navElements = document.querySelectorAll('.nav-link, .navbar-brand, .logout-btn');
            navElements.forEach(element => {
                element.style.caretColor = 'transparent';
                element.addEventListener('mousedown', function(e) {
                    if (!e.target.matches('input, textarea, select')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>