@extends('layouts.app')

@section('title', 'Delete Listing')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-uppercase text-danger small mb-2">Delete confirmation</p>
                    <h1 class="h3 mb-3">Delete "{{ $listing->title }}"?</h1>
                    <p class="text-muted">This action cannot be undone. The listing and its uploaded images will be removed from the marketplace.</p>

                    <div class="border rounded-4 p-3 mb-4 bg-light-subtle">
                        <div class="d-flex justify-content-between">
                            <span>{{ $listing->category->name }}</span>
                            <strong>${{ number_format((float) $listing->price, 2) }}</strong>
                        </div>
                        <small class="text-muted">{{ ucfirst($listing->condition) }} • Size {{ $listing->size }}</small>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <form method="POST" action="{{ route('listings.destroy', $listing) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Yes, delete listing</button>
                        </form>
                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
