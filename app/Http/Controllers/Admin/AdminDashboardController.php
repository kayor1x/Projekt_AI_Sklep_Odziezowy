<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'categoryCount' => Category::count(),
            'latestListings' => Listing::query()->with(['category', 'user'])->latest()->take(5)->get(),
            'listingCount' => Listing::count(),
            'userCount' => User::count(),
        ]);
    }
}
