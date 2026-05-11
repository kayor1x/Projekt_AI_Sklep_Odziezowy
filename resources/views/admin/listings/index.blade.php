@extends('layouts.app')

@section('title', 'Admin Listings')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">All listings</h1>
            <p class="text-muted mb-0">Admin overview of every marketplace item.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Seller</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($listings as $listing)
                            <tr>
                                <td>{{ $listing->title }}</td>
                                <td>{{ $listing->user->name }}</td>
                                <td>{{ $listing->category->name }}</td>
                                <td>${{ number_format((float) $listing->price, 2) }}</td>
                                <td>{{ ucfirst($listing->status) }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                        <a href="{{ route('admin.listings.edit', $listing) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="POST" action="{{ route('admin.listings.destroy', $listing) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No listings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $listings->links() }}
            </div>
        </div>
    </div>
@endsection
