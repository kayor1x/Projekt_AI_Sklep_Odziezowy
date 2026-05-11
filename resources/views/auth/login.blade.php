@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h1 class="h3 mb-2">Welcome back</h1>
    <p class="text-muted mb-4">Log in to manage your wardrobe listings.</p>

    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus autocomplete="username">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>

        <div class="d-flex justify-content-between small">
            <a href="{{ route('password.request') }}">Forgot password?</a>
            <a href="{{ route('register') }}">Create account</a>
        </div>
    </form>
@endsection
