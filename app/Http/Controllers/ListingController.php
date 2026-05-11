<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingFilterRequest;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function index(ListingFilterRequest $request): View
    {
        $filters = $request->validatedFilters();

        $listings = Listing::query()
            ->with(['category', 'user', 'primaryImage'])
            ->visible()
            ->applyFilters($filters)
            ->applySorting($filters['sort'] ?? 'newest')
            ->paginate(9)
            ->withQueryString();

        return view('listings.index', [
            'categories' => Category::query()->orderBy('name')->get(),
            'conditionOptions' => Listing::CONDITION_OPTIONS,
            'filters' => $filters,
            'listings' => $listings,
            'sizeOptions' => Listing::SIZE_OPTIONS,
        ]);
    }

    public function create(): View
    {
        return view('listings.create', [
            'categories' => Category::query()->orderBy('name')->get(),
            'conditionOptions' => Listing::CONDITION_OPTIONS,
            'listing' => new Listing(['status' => Listing::STATUS_ACTIVE]),
            'sizeOptions' => Listing::SIZE_OPTIONS,
        ]);
    }

    public function store(StoreListingRequest $request): RedirectResponse
    {
        $listing = $request->user()->listings()->create($request->safe()->except('images'));

        if ($request->hasFile('images')) {
            $listing->replaceImages($request->file('images'));
        }

        return redirect()
            ->route('listings.show', $listing)
            ->with('success', 'Listing created successfully.');
    }

    public function show(Listing $listing): View
    {
        $listing->load(['category', 'images', 'primaryImage', 'user']);

        return view('listings.show', compact('listing'));
    }

    public function edit(Listing $listing): View
    {
        $listing->load('images');

        return view('listings.edit', [
            'categories' => Category::query()->orderBy('name')->get(),
            'conditionOptions' => Listing::CONDITION_OPTIONS,
            'listing' => $listing,
            'sizeOptions' => Listing::SIZE_OPTIONS,
        ]);
    }

    public function update(UpdateListingRequest $request, Listing $listing): RedirectResponse
    {
        $listing->update($request->safe()->except('images'));

        if ($request->hasFile('images')) {
            $listing->replaceImages($request->file('images'));
        }

        return redirect()
            ->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully.');
    }

    public function confirmDelete(Listing $listing): View
    {
        return view('listings.confirm-delete', compact('listing'));
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $listing->deleteImageFiles();
        $listing->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Listing deleted successfully.');
    }

}
