@extends('layouts.app')

@section('title', 'Admin Edit Listing')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase text-muted small mb-1">Admin edit</p>
        <h1 class="h2 mb-1">{{ $listing->title }}</h1>
        <p class="text-muted mb-0">Moderate listing content and replace images when needed.</p>
    </div>

    @include('listings.form', [
        'action' => route('admin.listings.update', $listing),
        'cancelUrl' => route('admin.listings.index'),
        'method' => 'PUT',
        'submitLabel' => 'Save admin changes',
    ])
@endsection
