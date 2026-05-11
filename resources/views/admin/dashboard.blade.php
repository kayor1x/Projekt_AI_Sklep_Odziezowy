@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <p class="text-uppercase text-muted small mb-1">Admin panel</p>
            <h1 class="h2 mb-1">Marketplace overview</h1>
            <p class="text-muted mb-0">Moderate categories, inspect listings, and keep the marketplace organized.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark">Manage categories</a>
            <a href="{{ route('admin.listings.index') }}" class="btn btn-primary">Review listings</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Users</p>
                    <h2 class="mb-0">{{ $userCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Listings</p>
                    <h2 class="mb-0">{{ $listingCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Categories</p>
                    <h2 class="mb-0">{{ $categoryCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h2 class="h4 mb-3">Latest listings</h2>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Seller</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestListings as $listing)
                            <tr>
                                <td>{{ $listing->title }}</td>
                                <td>{{ $listing->user->name }}</td>
                                <td>{{ $listing->category->name }}</td>
                                <td>${{ number_format((float) $listing->price, 2) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.listings.edit', $listing) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
