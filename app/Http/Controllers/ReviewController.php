<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Listing;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Review Controller
 */
class ReviewController extends Controller
{
    /**
     * Store a new review for a listing
     */
    public function store(StoreReviewRequest $request, $listingId)
    {
        $validated = $request->validated();
        $listing = Listing::findOrFail($listingId);

        // Create new review
        $review = new Review($validated['review']);
        $review->author_id = Auth::id(); // Already logged in
        $review->listing_id = $listing->id;
        $review->save();

        return redirect()->route('listings.show', $listing->id)
            ->with('success', 'New Review Created!');
    }

    /**
     * Delete a review
     */
    public function destroy($listingId, $reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->delete();

        return redirect()->route('listings.show', $listingId)
            ->with('success', 'Review Deleted!');
    }
}
