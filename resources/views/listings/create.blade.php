@extends('layouts.app')

@section('title', 'Create Listing')

@section('content')
    <div class="mb-4">
        <p class="text-uppercase text-muted small mb-1">Create listing</p>
        <h1 class="h2 mb-1">Sell a clothing item</h1>
        <p class="text-muted mb-0">Fill in clear product details and upload up to three photos.</p>
    </div>

    @include('listings.form', [
        'action' => route('listings.store'),
        'cancelUrl' => route('dashboard'),
        'submitLabel' => 'Publish listing',
    ])
@endsection
