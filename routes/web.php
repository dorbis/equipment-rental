<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AdminController;

Route::get('/', [ListingController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('listings.index');
})->middleware(['auth'])->name('dashboard');

Route::get('/listings/search', [ListingController::class, 'search'])
    ->name('listings.search');

Route::get('/listings', [ListingController::class, 'index'])
    ->name('listings.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/listings/create', [ListingController::class, 'create'])
        ->name('listings.create');

    Route::post('/listings', [ListingController::class, 'store'])
        ->name('listings.store');

    Route::get('/my-rentals', [RentalController::class, 'index'])
        ->name('rentals.index');

    Route::post('/rentals', [RentalController::class, 'store'])
        ->name('rentals.store');

    Route::get('/my-listings', [ListingController::class, 'myListings'])
        ->name('listings.my');

    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])
        ->name('listings.edit');

    Route::put('/listings/{listing}', [ListingController::class, 'update'])
        ->name('listings.update');

    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])
        ->name('listings.destroy');

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');

    Route::delete('/admin/listings/{listing}', [AdminController::class, 'destroyListing'])
        ->name('admin.listings.destroy');
});

Route::get('/listings/{listing}', [ListingController::class, 'show'])
    ->name('listings.show');

require __DIR__.'/auth.php';