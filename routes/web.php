<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\EnsureListingOwner;
use App\Http\Middleware\EnsureReviewAuthor;
use App\Http\Middleware\SaveIntendedUrl;
use Illuminate\Support\Facades\Route;




Route::get('/', [ListingController::class, 'index'])->name('home');



Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

Route::get('/listings/new', [ListingController::class, 'create'])
    ->middleware('auth')
    ->name('listings.create');

Route::post('/listings', [ListingController::class, 'store'])
    ->middleware('auth')
    ->name('listings.store');

Route::get('/listings/{id}', [ListingController::class, 'show'])->name('listings.show');

Route::post('/listings/{id}/track-click', [ListingController::class, 'trackClick'])
    ->middleware('auth')
    ->name('listings.trackClick');

Route::get('/listings/{id}/edit', [ListingController::class, 'edit'])
    ->middleware(['auth', EnsureListingOwner::class])
    ->name('listings.edit');

Route::put('/listings/{id}', [ListingController::class, 'update'])
    ->middleware(['auth', EnsureListingOwner::class])
    ->name('listings.update');

Route::delete('/listings/{id}', [ListingController::class, 'destroy'])
    ->middleware(['auth', EnsureListingOwner::class])
    ->name('listings.destroy');
