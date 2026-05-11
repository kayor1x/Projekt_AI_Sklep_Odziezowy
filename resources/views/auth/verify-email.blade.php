@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
    <h1 class="h3 mb-2">Verify your email</h1>
    <p class="text-muted mb-4">Thanks for registering. Please verify your email address by clicking the link we sent you.</p>

    <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-primary w-100">Resend verification email</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary w-100">Logout</button>
    </form>
@endsection
