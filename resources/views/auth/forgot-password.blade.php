@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
    <h1 class="h3 mb-2">Reset your password</h1>
    <p class="text-muted mb-4">Enter your email and we will send you a password reset link.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send reset link</button>
    </form>
@endsection
