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

        $listings = Listing::with(['user', 'category'])
            ->latest()
            ->get();

        return view('admin.index', compact('listings'));
    }

    public function destroyListing(Listing $listing)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $listing->delete();

        return back()->with('success', 'Sludinājums dzēsts.');
    }
}