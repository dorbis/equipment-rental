<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::with(['category', 'user'])
            ->latest()
            ->paginate(10);

        $categories = Category::all();

        return view('listings.index', compact('listings', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('listings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:equipment,work',
            'category_id' => 'required|exists:categories,id',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = Auth::id();

        Listing::create($validated);

        return redirect()
            ->route('listings.index')
            ->with('success', 'Sludinājums veiksmīgi izveidots.');
    }

    public function show(Listing $listing)
    {
        $listing->load(['category', 'user']);

        return view('listings.show', compact('listing'));
    }

    public function edit(Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();

        return view('listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:equipment,work',
            'category_id' => 'required|exists:categories,id',
            'price_per_day' => 'required|numeric|min:0',
        ]);

        $listing->update($validated);

        return redirect()
            ->route('listings.show', $listing)
            ->with('success', 'Sludinājums veiksmīgi atjaunināts.');
    }

    public function destroy(Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403);
        }

        $listing->delete();

        return redirect()
            ->route('listings.my')
            ->with('success', 'Sludinājums veiksmīgi dzēsts.');
    }

    public function search(Request $request)
    {
        $query = Listing::with(['category', 'user']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('q')) {
            $search = $request->input('q');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $listings = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('listings.index', compact('listings', 'categories'));
    }

    public function myListings()
    {
        $listings = Listing::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('listings.my', compact('listings'));
    }
}