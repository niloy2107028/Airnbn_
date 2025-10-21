<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show booking form for a listing
     */
    public function create(Listing $listing)
    {
        // Only guests can book
        if (!Auth::user()->isGuest()) {
            return redirect()->route('listings.show', $listing)->with('error', 'Only guests can make bookings.');
        }

        // Check if guest has active booking
        if (Auth::user()->hasActiveBooking()) {
            return redirect()->route('listings.show', $listing)->with('error', 'You already have an active booking. Please complete or cancel it before making a new booking.');
        }

        return view('bookings.create', compact('listing'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request, Listing $listing)
    {
        // Only guests can book
        if (!Auth::user()->isGuest()) {
            return redirect()->route('listings.show', $listing)->with('error', 'Only guests can make bookings.');
        }

        // Check if guest has active booking
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
     * Show user's bookings (for guests)
     */
    public function myBookings()
    {
        $bookings = Auth::user()->bookings()->with('listing')->latest()->get();
        $hostName = Auth::user()->username;
        return view('bookings.my-bookings', compact('bookings', 'hostName'));
    }

    /**
     * Host dashboard - show pending bookings
     */
    public function hostDashboard()
    {
        if (!Auth::user()->isHost()) {
            return redirect()->route('home')->with('error', 'Only hosts can access this page.');
        }

        // Get host's listings
        $myListings = Auth::user()->listings()->latest()->get();

        // Get pending bookings for host's listings
        $pendingBookings = Auth::user()->pendingBookings();

        // Get all bookings for host's listings
        $allBookings = Booking::whereHas('listing', function ($query) {
            $query->where('owner_id', Auth::id());
        })->with(['listing', 'user'])->latest()->get();

        $hostName = Auth::user()->username;
        return view('bookings.host-dashboard', compact('myListings', 'pendingBookings', 'allBookings', 'hostName'));
    }

    /**
     * Host confirms a booking
     */
    public function confirm(Booking $booking)
    {
        // Only listing owner can confirm
        if ($booking->listing->owner_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$booking->isPending()) {
            return redirect()->back()->with('error', 'This booking is not pending.');
        }

        $booking->update(['status' => 'confirmed']);

        // Increment trending points when booking is confirmed
        $booking->listing->incrementTrendingPoints();

        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Host rejects a booking
     */
    public function reject(Booking $booking)
    {
        // Only listing owner can reject
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
     * Guest cancels a booking
     */
    public function cancel(Booking $booking)
    {
        // Only the guest who made booking can cancel
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
