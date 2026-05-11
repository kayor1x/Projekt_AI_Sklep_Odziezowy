@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <h1 class="h3 mb-2">Create your account</h1>
    <p class="text-muted mb-4">Join the marketplace to sell clothes and manage your listings.</p>

    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autocomplete="name">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="username">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>

        <div class="small text-center">
            Already registered? <a href="{{ route('login') }}">Login here</a>
        </div>
    </form>
@endsection
