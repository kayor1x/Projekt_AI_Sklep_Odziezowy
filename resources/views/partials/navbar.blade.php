<nav class="navbar navbar-expand-lg navbar-light marketplace-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Marketplace</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home', 'listings.*') ? 'active' : '' }}" href="{{ route('listings.index') }}">Browse</a>
                </li>
                @auth
                    @if (! auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">My Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <div class="d-flex align-items-center gap-2">
                @auth
                    @if (! auth()->user()->isAdmin())
                        <a href="{{ route('listings.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Sell Item
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
