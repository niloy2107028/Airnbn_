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



Route::post('/listings/{id}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');

Route::delete('/listings/{id}/reviews/{reviewId}', [ReviewController::class, 'destroy'])
    ->middleware(['auth', EnsureReviewAuthor::class])
    ->name('reviews.destroy');



Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');

Route::post('/signup', [AuthController::class, 'signup']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware(SaveIntendedUrl::class);

Route::get('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/listings/{listing}/book', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/listings/{listing}/book', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');

    Route::get('/my-bookings', [BookingController::class, 'myBookings'])
        ->name('bookings.my-bookings');

    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/host/dashboard', [BookingController::class, 'hostDashboard'])
        ->name('bookings.host-dashboard');

    Route::patch('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])
        ->name('bookings.confirm');

    Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])
        ->name('bookings.reject');
});
