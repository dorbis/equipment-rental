<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'listing_id' => 'required|exists:listings,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'note' => 'nullable|string|max:1000',
        ]);

        $listing = Listing::findOrFail($validated['listing_id']);

        if ($listing->user_id === Auth::id()) {
            return back()->withErrors([
                'listing_id' => 'Jūs nevarat rezervēt savu sludinājumu.'
            ]);
        }

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $days = $startDate->diffInDays($endDate) + 1;
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