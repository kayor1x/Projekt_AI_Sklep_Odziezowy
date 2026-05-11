<form method="POST" action="{{ $action }}" class="needs-validation" novalidate>
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="mb-4">
                <label for="name" class="form-label">Category name</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" maxlength="80" required>
                <div class="form-text">Example: Jackets, Dresses, Shoes.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
