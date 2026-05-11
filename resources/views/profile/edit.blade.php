@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h1 class="h4 mb-3">Profile information</h1>
                    <form method="POST" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" @disabled($user->isAdmin()) required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" @disabled($user->isAdmin()) required>
                        </div>

                        @if (! $user->isAdmin())
                            <button type="submit" class="btn btn-primary">Save profile</button>
                        @else
                            <p class="text-muted mb-0">Admin name and email are read-only.</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">Update password</h2>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="update_password_current_password" class="form-label">Current password</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                            @if ($errors->updatePassword->has('current_password'))
                                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password" class="form-label">New password</label>
                            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
                            @if ($errors->updatePassword->has('password'))
                                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password_confirmation" class="form-label">Confirm new password</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-outline-primary">Update password</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3 text-danger">Delete account</h2>
                    <p class="text-muted">This action is permanent and will remove your account.</p>

                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('DELETE')

                        <div class="mb-3">
                            <label for="delete_password" class="form-label">Confirm password</label>
                            <input id="delete_password" name="password" type="password" class="form-control" required>
                            @if ($errors->userDeletion->has('password'))
                                <div class="text-danger small mt-1">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-danger">Delete account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
