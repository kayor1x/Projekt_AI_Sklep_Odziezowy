<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $myListings = Listing::query()
            ->ownedBy($user)
            ->with(['category', 'primaryImage'])
            ->latest()
            ->paginate(8);

        return view('dashboard', [
            'activeCount' => $user->listings()->where('status', Listing::STATUS_ACTIVE)->count(),
            'myListings' => $myListings,
            'soldCount' => $user->listings()->where('status', Listing::STATUS_SOLD)->count(),
            'totalCount' => $user->listings()->count(),
        ]);
    }
}
