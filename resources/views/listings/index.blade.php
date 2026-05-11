@extends('layouts.app')

@section('title', 'Browse Listings')

@section('content')
    <section class="hero-panel mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="eyebrow mb-2">Clothes Marketplace</p>
                <h1 class="display-6 fw-bold mb-3">An online marketplace designed for the sale and exchange of second-hand clothing.</h1>
                <p class="text-muted mb-0">Browse listings, filter by practical clothing attributes, and manage your own offers after login.</p>
            </div>
            <div class="col-lg-5">
                <div class="hero-stats">
                    <div>
                        <strong>{{ $listings->total() }}</strong>
                        <span>visible listings</span>
                    </div>
                    <div>
                        <strong>{{ $categories->count() }}</strong>
                        <span>categories</span>
                    </div>
                    <div>
                        <strong>{{ count($sizeOptions) }}</strong>
                        <span>sizes</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">Filters</h2>
                    <form method="GET" action="{{ route('listings.index') }}">
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input id="search" type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="Brand, item, description">
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select id="category_id" name="category_id" class="form-select">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(($filters['category_id'] ?? null) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label for="price_min" class="form-label">Min price</label>
                                <input id="price_min" type="number" name="price_min" step="0.01" min="0" class="form-control" value="{{ $filters['price_min'] ?? '' }}">
                            </div>
                            <div class="col-6">
                                <label for="price_max" class="form-label">Max price</label>
                                <input id="price_max" type="number" name="price_max" step="0.01" min="0" class="form-control" value="{{ $filters['price_max'] ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="size" class="form-label">Size</label>
                            <select id="size" name="size" class="form-select">
                                <option value="">All sizes</option>
                                @foreach ($sizeOptions as $size)
                                    <option value="{{ $size }}" @selected(($filters['size'] ?? null) === $size)>{{ $size }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="condition" class="form-label">Condition</label>
                            <select id="condition" name="condition" class="form-select">
                                <option value="">Any condition</option>
                                @foreach ($conditionOptions as $condition)
                                    <option value="{{ $condition }}" @selected(($filters['condition'] ?? null) === $condition)>{{ ucfirst($condition) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="sort" class="form-label">Sort by</label>
                            <select id="sort" name="sort" class="form-select">
                                <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Newest</option>
                                <option value="oldest" @selected(($filters['sort'] ?? null) === 'oldest')>Oldest</option>
                                <option value="price_asc" @selected(($filters['sort'] ?? null) === 'price_asc')>Price low to high</option>
                                <option value="price_desc" @selected(($filters['sort'] ?? null) === 'price_desc')>Price high to low</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Apply filters</button>
                            <a href="{{ route('listings.index') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 mb-0">Marketplace listings</h2>
                <span class="text-muted">{{ $listings->total() }} results</span>
            </div>

            <div class="row g-4">
                @forelse ($listings as $listing)
                    <div class="col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm listing-card h-100">
                            <div class="listing-card-image">
                                @if ($listing->primary_image_url)
                                    <img src="{{ $listing->primary_image_url }}" alt="{{ $listing->title }}">
                                @else
                                    <div class="listing-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge text-bg-light border">{{ $listing->category->name }}</span>
                                    <span class="fw-semibold">${{ number_format((float) $listing->price, 2) }}</span>
                                </div>
                                <h3 class="h5">{{ $listing->title }}</h3>
                                <p class="text-muted small">{{ ucfirst($listing->condition) }} • Size {{ $listing->size }} • Seller: {{ $listing->user->name }}</p>
                                <p class="text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit($listing->description, 90) }}</p>
                                <a href="{{ route('listings.show', $listing) }}" class="btn btn-outline-dark mt-2">View details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-search display-5 text-muted"></i>
                                <h3 class="h4 mt-3">No listings match these filters</h3>
                                <p class="text-muted">Try widening your price range or choosing a different category.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $listings->links() }}
            </div>
        </div>
    </div>
@endsection
