<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ListingController::class, 'index'])->name('home');

Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/search', [ListingController::class, 'search'])->name('listings.search');

Route::middleware('auth')->group(function () {
    Route::get('/my-listings', [ListingController::class, 'myListings'])->name('listings.my');

    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');

    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');

    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::post('/rentals/{listing}', [RentalController::class, 'store'])->name('rentals.store');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/listings/{listing}', [AdminController::class, 'destroyListing'])->name('admin.listings.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

Route::get('/dashboard', function () {
    return redirect()->route('listings.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';