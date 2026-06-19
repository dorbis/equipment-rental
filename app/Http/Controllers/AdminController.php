<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $listings = Listing::with(['category', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.index', compact('listings'));
    }

    public function destroyListing(Listing $listing)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $listing->delete();

        return redirect()
            ->route('admin.index')
            ->with('success', 'Sludinājums veiksmīgi dzēsts.');
    }
}