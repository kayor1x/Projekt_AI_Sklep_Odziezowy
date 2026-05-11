@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <p class="text-uppercase text-muted small mb-1">Seller dashboard</p>
            <h1 class="h2 mb-1">Manage your listings</h1>
            <p class="text-muted mb-0">Track your clothes, update details, and keep your offers fresh.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Total listings</p>
                    <h2 class="mb-0">{{ $totalCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Active</p>
                    <h2 class="mb-0">{{ $activeCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <p class="text-muted mb-1">Sold</p>
                    <h2 class="mb-0">{{ $soldCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 mb-0">My items</h2>
                <span class="text-muted small">{{ $myListings->total() }} items</span>
            </div>

            @forelse ($myListings as $listing)
                <div class="border rounded-4 p-3 mb-3">
                    <div class="row align-items-center g-3">
                        <div class="col-md-2">
                            <div class="listing-thumb-small">
                                @if ($listing->primary_image_url)
                                    <img src="{{ $listing->primary_image_url }}" alt="{{ $listing->title }}">
                                @else
                                    <i class="bi bi-image"></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h3 class="h5 mb-1">{{ $listing->title }}</h3>
                            <p class="text-muted mb-1">{{ $listing->category->name }} • {{ $listing->size }} • {{ ucfirst($listing->condition) }}</p>
                            <small class="text-muted">Updated {{ $listing->updated_at->diffForHumans() }}</small>
                        </div>
                        <div class="col-md-2">
                            <span class="badge text-bg-light border">{{ ucfirst($listing->status) }}</span>
                            <div class="fw-semibold mt-2">${{ number_format((float) $listing->price, 2) }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                <a href="{{ route('listings.show', $listing) }}" class="btn btn-outline-secondary btn-sm">View</a>
                                <a href="{{ route('listings.edit', $listing) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                <a href="{{ route('listings.confirm-delete', $listing) }}" class="btn btn-outline-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-bag display-5 text-muted"></i>
                    <h3 class="h4 mt-3">No listings yet</h3>
                    <p class="text-muted">Start with one item and your dashboard will fill up here.</p>
                    <a href="{{ route('listings.create') }}" class="btn btn-primary">Create first listing</a>
                </div>
            @endforelse

            {{ $myListings->links() }}
        </div>
    </div>
@endsection
