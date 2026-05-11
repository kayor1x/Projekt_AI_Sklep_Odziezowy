@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="mb-4">
        <h1 class="h2 mb-1">Edit category</h1>
        <p class="text-muted mb-0">Update the category name and keep slugs consistent.</p>
    </div>

    @include('admin.categories.form', [
        'action' => route('admin.categories.update', $category),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
@endsection
