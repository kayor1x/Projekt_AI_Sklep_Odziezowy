@php
    $isEdit = $listing->exists;
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @if ($isEdit)
        @method($method ?? 'PUT')
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">Listing details</h2>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input id="title" type="text" name="title" class="form-control" value="{{ old('title', $listing->title) }}" maxlength="120" required>
                        <div class="form-text">Make it short and specific.</div>
                    </div>

                    <div class="mb-0">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="6" minlength="20" maxlength="2000" required>{{ old('description', $listing->description) }}</textarea>
                        <div class="form-text">Include fit, brand, color, and any visible wear.</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3">Images</h2>
                    <div class="mb-3">
                        <label for="images" class="form-label">Upload up to 3 images</label>
                        <input id="images" type="file" name="images[]" class="form-control" accept=".jpg,.jpeg,.png,.webp" multiple>
                        <div class="form-text">Allowed: JPG, PNG, WEBP. Max 2 MB per image.</div>
                    </div>

                    @if ($isEdit && $listing->images->isNotEmpty())
                        <div class="row g-3">
                            @foreach ($listing->images as $image)
                                <div class="col-sm-4">
                                    <div class="border rounded-4 overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Listing image" class="img-fluid w-100 form-image-preview">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-lg-top listing-form-sidebar">
                <div class="card-body">
                    <h2 class="h4 mb-3">Attributes</h2>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (USD)</label>
                        <input id="price" type="number" name="price" class="form-control" value="{{ old('price', $listing->price) }}" min="0.01" max="99999.99" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            <option value="">Choose category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $listing->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="condition" class="form-label">Condition</label>
                        <select id="condition" name="condition" class="form-select" required>
                            <option value="">Choose condition</option>
                            @foreach ($conditionOptions as $condition)
                                <option value="{{ $condition }}" @selected(old('condition', $listing->condition) === $condition)>
                                    {{ ucfirst($condition) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="size" class="form-label">Size</label>
                        <select id="size" name="size" class="form-select" required>
                            <option value="">Choose size</option>
                            @foreach ($sizeOptions as $size)
                                <option value="{{ $size }}" @selected(old('size', $listing->size) === $size)>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
                        <a href="{{ $cancelUrl }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
