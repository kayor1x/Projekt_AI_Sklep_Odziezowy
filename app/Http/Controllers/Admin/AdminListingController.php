<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminListingController extends Controller
{
    public function index(): View
    {
        return view('admin.listings.index', [
            'listings' => Listing::query()
                ->with(['category', 'user', 'primaryImage'])
                ->latest()
                ->paginate(12),
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('listings.create');
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('listings.create');
    }

    public function show(Listing $listing): RedirectResponse
    {
        return redirect()->route('listings.show', $listing);
    }

    public function edit(Listing $listing): View
    {
        $listing->load('images');

        return view('admin.listings.edit', [
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
            ->route('admin.listings.index')
            ->with('success', 'Listing updated successfully.');
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $listing->deleteImageFiles();
        $listing->delete();

        return redirect()
            ->route('admin.listings.index')
            ->with('success', 'Listing deleted successfully.');
    }
}
