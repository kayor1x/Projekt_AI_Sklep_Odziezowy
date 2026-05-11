<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;

Route::get('/', [ListingController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->whereNumber('listing')->name('listings.show');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/listings/create', [ListingController::class, 'create'])
        ->middleware('can:create,' . Listing::class)
        ->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])
        ->middleware('can:create,' . Listing::class)
        ->name('listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])
        ->whereNumber('listing')
        ->middleware('can:update,listing')
        ->name('listings.edit');
    Route::match(['put', 'patch'], '/listings/{listing}', [ListingController::class, 'update'])
        ->whereNumber('listing')
        ->middleware('can:update,listing')
        ->name('listings.update');
    Route::get('/listings/{listing}/delete', [ListingController::class, 'confirmDelete'])
        ->whereNumber('listing')
        ->middleware('can:delete,listing')
        ->name('listings.confirm-delete');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])
        ->whereNumber('listing')
        ->middleware('can:delete,listing')
        ->name('listings.destroy');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('listings', AdminListingController::class)->except(['create', 'store', 'show']);
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});

require __DIR__.'/auth.php';
