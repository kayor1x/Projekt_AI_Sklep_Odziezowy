@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
    <div class="mb-4">
        <h1 class="h2 mb-1">Create category</h1>
        <p class="text-muted mb-0">Add a clear category for marketplace items.</p>
    </div>

    @include('admin.categories.form', [
        'action' => route('admin.categories.store'),
        'submitLabel' => 'Create category',
    ])
@endsection
