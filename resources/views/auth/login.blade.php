@extends('layouts.auth')

@section('content')
<h5 class="card-title text-center mb-4">Login to Your Account</h5>

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-success btn-lg">Login</button>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('register') }}">Don't have an account? Register here</a>
    </div>
</form>
@endsection