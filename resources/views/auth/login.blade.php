@extends('layouts.app')

@section('title', 'Sign In - SkyConnect')

@section('content')
<style>
    body {
        background: url('https://wallpaperaccess.com/full/896979.jpg') no-repeat center center fixed !important;
        background-size: cover !important;
        padding-top: 0 !important;
    }
    .navbar, .navbar.scrolled {
        background: transparent !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        border: none !important;
        box-shadow: none !important;
        padding: 20px 0 !important;
        margin: 0 !important;
    }
    .navbar .navbar-collapse {
        display: none !important;
    }
    .navbar .container-fluid {
        justify-content: flex-start !important;
    }
    .brand-icon, .fw-800 {
        color: white !important;
    }
    /* Darker text for white card contrast */
    .fw-800.text-dark { color: #000000 !important; }
    .text-secondary { color: #4a4a4a !important; font-weight: 600 !important; }
    .form-control { background: #f8f9fa !important; color: #000000 !important; border: 1px solid #dee2e6 !important; }
    label { color: #2d2d2d !important; font-weight: 600 !important; }
    /* Permanently hide placeholder */
    .form-control::placeholder {
        color: transparent !important;
    }
    .form-control:focus::placeholder, .form-control:hover::placeholder {
        color: transparent !important;
    }
</style>

<div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="card p-4 text-center border-0 shadow-lg" style="max-width: 420px; width: 100%; border-radius: 30px !important;">
        <div class="card-body py-4">
            <div class="mb-4">
                <i class="fas fa-plane-departure text-primary fa-3x mb-3"></i>
                <h2 class="fw-800 text-dark mb-1" style="letter-spacing: -1px;">Welcome Back</h2>
                <p class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 1px;">Sign in to your account</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 small mb-4 text-start" style="border-radius: 15px;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="email" class="form-control border-0 bg-light rounded-4 px-4" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                    <label for="email" class="ps-4 text-secondary small">Email Address</label>
                </div>

                <div class="form-floating mb-3 position-relative">
                    <input type="password" class="form-control border-0 bg-light rounded-4 px-4" id="password" name="password" placeholder="Password" required>
                    <label for="password" class="ps-4 text-secondary small">Password</label>
                    <button type="button" class="btn btn-link position-absolute end-0 top-0 mt-2 me-2 text-secondary toggle-password shadow-none" data-target="password" style="z-index: 10;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label small text-secondary fw-bold" for="remember">Keep me signed in</label>
                    </div>
                    <a class="text-decoration-none small fw-bold text-primary" href="#">Forgot?</a>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-lg py-3 rounded-pill fw-800">
                        Sign In
                    </button>
                </div>

                <div class="mt-5">
                    <p class="text-secondary small mb-0 fw-bold">NO ACCOUNT YET?</p>
                    <a href="{{ route('register') }}" class="text-decoration-none fw-800 text-primary" style="font-size: 1.1rem;">Create Your Identity</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection