@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('content')
    <h1 class="h3 mb-2">Confirm your password</h1>
    <p class="text-muted mb-4">For security, please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Confirm</button>
    </form>
@endsection
