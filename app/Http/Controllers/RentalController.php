<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['listing', 'listing.category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('rentals.index', compact('rentals'));
    }

    public function store(Request $request, Listing $listing)
    {
        if ($listing->user_id === Auth::id()) {
            return redirect()
                ->route('listings.show', $listing)
                ->with('success', 'Jūs nevarat rezervēt savu sludinājumu.');
        }

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'note' => 'nullable|string|max:1000',
        ]);

        $start = new \DateTime($validated['start_date']);
        $end = new \DateTime($validated['end_date']);
        $days = $start->diff($end)->days + 1;

        $totalPrice = $days * $listing->price_per_day;

        Rental::create([
            'user_id' => Auth::id(),
            'listing_id' => $listing->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'note' => $validated['note'] ?? null,
            'total_price' => $totalPrice,
        ]);

        return redirect()
            ->route('rentals.index')
            ->with('success', 'Rezervācija veiksmīgi izveidota.');
    }
}