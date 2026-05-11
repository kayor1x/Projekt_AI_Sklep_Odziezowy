@extends('layouts.app')

@section('title', 'Edit Listing')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase text-muted small mb-1">Edit listing</p>
        <h1 class="h2 mb-1">{{ $listing->title }}</h1>
        <p class="text-muted mb-0">Update your item details and replace photos if needed.</p>
    </div>

    @include('listings.form', [
        'action' => route('listings.update', $listing),
        'cancelUrl' => route('listings.show', $listing),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
@endsection
