@extends('layouts.app')

@section('title', $listing->title)

@section('content')
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        @if ($listing->images->isNotEmpty())
                            @foreach ($listing->images as $image)
                                <div class="col-sm-6">
                                    <div class="detail-image-card">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $listing->title }}" class="img-fluid w-100">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="detail-placeholder">
                                    <i class="bi bi-image display-4"></i>
                                    <p class="mb-0">No image uploaded</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-uppercase small text-muted mb-2">{{ $listing->category->name }}</p>
                    <h1 class="h2 mb-3">{{ $listing->title }}</h1>
                    <p class="lead mb-4">${{ number_format((float) $listing->price, 2) }}</p>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <div class="attribute-box">
                                <span>Condition</span>
                                <strong>{{ ucfirst($listing->condition) }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="attribute-box">
                                <span>Size</span>
                                <strong>{{ $listing->size }}</strong>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="attribute-box">
                                <span>Status</span>
                                <strong>{{ ucfirst($listing->status) }}</strong>
                            </div>
                        </div>
                    </div>

                    <h2 class="h4">Description</h2>
                    <p class="mb-0">{{ $listing->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">Seller</h2>
                    <p class="mb-1"><strong>{{ $listing->user->name }}</strong></p>
                    <p class="text-muted mb-1">{{ $listing->user->email }}</p>
                    <p class="text-muted mb-0">Listed {{ $listing->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3">Actions</h2>
                    <div class="d-grid gap-2">
                        <a href="{{ route('listings.index') }}" class="btn btn-outline-secondary">Back to listings</a>
                        @auth
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.listings.edit', $listing) }}" class="btn btn-outline-dark">Open in admin panel</a>
                            @endif
                            @if (! auth()->user()->isAdmin())
                                @can('update', $listing)
                                    <a href="{{ route('listings.edit', $listing) }}" class="btn btn-primary">Edit listing</a>
                                @endcan
                            @endif
                            @can('delete', $listing)
                                <a href="{{ route('listings.confirm-delete', $listing) }}" class="btn btn-outline-danger">Delete listing</a>
                            @endcan
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Login to sell your own items</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
