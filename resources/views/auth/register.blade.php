@extends('layouts.app')

@section('title', 'Join SkyConnect')

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
    .form-check-label { color: #4a4a4a !important; font-weight: 600 !important; }
    /* Permanently hide placeholder */
    .form-control::placeholder {
        color: transparent !important;
    }
    .form-control:focus::placeholder, .form-control:hover::placeholder {
        color: transparent !important;
    }
</style>

<div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="card p-4 text-center border-0 shadow-lg" style="max-width: 450px; width: 100%; border-radius: 30px !important;">
        <div class="card-body py-4">
            <div class="mb-4">
                <i class="fas fa-user-plus text-primary fa-3x mb-3"></i>
                <h2 class="fw-800 text-dark mb-1" style="letter-spacing: -1px;">Join SkyConnect</h2>
                <p class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 1px;">Establish your elite membership</p>
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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control border-0 bg-light rounded-4 px-4" id="name" name="name" value="{{ old('name') }}" placeholder="Full Name" required autofocus>
                    <label for="name" class="ps-4 text-secondary small">Full Name</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control border-0 bg-light rounded-4 px-4" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                    <label for="email" class="ps-4 text-secondary small">Email Address</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control border-0 bg-light rounded-4 px-4" id="password" name="password" placeholder="Password" required>
                    <label for="password" class="ps-4 text-secondary small">Choose Password</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" class="form-control border-0 bg-light rounded-4 px-4" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                    <label for="password_confirmation" class="ps-4 text-secondary small">Confirm Password</label>
                </div>

                <div class="mb-4 text-start px-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label small text-secondary fw-bold" for="terms">
                            I accept the <a href="#" class="text-primary text-decoration-none">Terms of Excellence</a>
                        </label>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-lg py-3 rounded-pill fw-800">
                        Become a Member
                    </button>
                </div>

                <div class="mt-5">
                    <p class="text-secondary small mb-0 fw-bold">ALREADY REGISTERED?</p>
                    <a href="{{ route('login') }}" class="text-decoration-none fw-800 text-primary" style="font-size: 1.1rem;">Sign In to Your Account</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection