<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * booking form dekhabo
     */
    public function create(Listing $listing)
    {
        // sudhu guest ra book korte parbe
        if (!Auth::user()->isGuest()) {
            return redirect()->route('listings.show', $listing)->with('error', 'Only guests can make bookings.');
        }

        // guest er already active booking ache kina check
        if (Auth::user()->hasActiveBooking()) {
            return redirect()->route('listings.show', $listing)->with('error', 'You already have an active booking. Please complete or cancel it before making a new booking.');
        }

        return view('bookings.create', compact('listing'));
    }

    /**
     * booking save korbo
     */
    public function store(Request $request, Listing $listing)
    {
        // abar check korbo guest kina
        if (!Auth::user()->isGuest()) {
            return redirect()->route('listings.show', $listing)->with('error', 'Only guests can make bookings.');
        }

        // active booking check
        if (Auth::user()->hasActiveBooking()) {
            return redirect()->route('listings.show', $listing)->with('error', 'You already have an active booking.');
        }

        $validated = $request->validate([
            'persons' => 'required|integer|min:1|max:20',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'special_requests' => 'nullable|string|max:500'
        ]);

        $booking = Booking::create([
            'listing_id' => $listing->id,
            'user_id' => Auth::id(),
            'persons' => $validated['persons'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'special_requests' => $validated['special_requests'] ?? null,
            'status' => 'pending'
        ]);


        $bookings = Auth::user()->bookings()->with('listing')->latest()->get();
        $hostName = Auth::user()->username;
        return view('bookings.my-bookings', compact('bookings', 'hostName'))->with('success', 'Booking request sent! Waiting for host confirmation.');
    }


    /**
     * user er bookings dekhabo
     */
    public function myBookings()
    {
        $bookings = Auth::user()->bookings()->with('listing')->latest()->get();
        $hostName = Auth::user()->username;
        return view('bookings.my-bookings', compact('bookings', 'hostName'));
    }

    /**
     * host dashboard e pending bookings dekhabo
     */
    public function hostDashboard()
    {
        if (!Auth::user()->isHost()) {
            return redirect()->route('home')->with('error', 'Only hosts can access this page.');
        }

        // host er sob listings
        $myListings = Auth::user()->listings()->latest()->get();

        // pending bookings
        $pendingBookings = Auth::user()->pendingBookings();

        // all bookings
        $allBookings = Booking::whereHas('listing', function ($query) {
            $query->where('owner_id', Auth::id());
        })->with(['listing', 'user'])->latest()->get();

        $hostName = Auth::user()->username;
        return view('bookings.host-dashboard', compact('myListings', 'pendingBookings', 'allBookings', 'hostName'));
    }

    /**
     * host booking confirm korbe
     */
    public function confirm(Booking $booking)
    {
        // sudhu listing owner e confirm korte parbe
        if ($booking->listing->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$booking->isPending()) {
            return redirect()->back()->with('error', 'This booking is not pending.');
        }

        $booking->update(['status' => 'confirmed']);

        // booking confirm hole trending point badhbe
        $booking->listing->incrementTrendingPoints();

        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }

    /**
     * host booking reject korbe
     */
    public function reject(Booking $booking)
    {
        // owner e reject korte parbe
        if ($booking->listing->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$booking->isPending()) {
            return redirect()->back()->with('error', 'This booking is not pending.');
        }

        $booking->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Booking rejected.');
    }

    /**
     * guest booking cancel korte parbe
     */
    public function cancel(Booking $booking)
    {
        // je guest booking koreche se e cancel korte parbe
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->isConfirmed() && $booking->check_in_date->isPast()) {
            return redirect()->back()->with('error', 'Cannot cancel a booking that has already started.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.my-bookings')->with('success', 'Booking cancelled successfully.');
    }
}
