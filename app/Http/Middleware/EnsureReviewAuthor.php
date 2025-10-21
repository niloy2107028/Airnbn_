<?php

namespace App\Http\Middleware;

use App\Models\Review;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureReviewAuthor
{
    /**
     * Handle an incoming request.
     * Checks if the authenticated user is the author of the review
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $reviewId = $request->route('reviewId') ?? $request->route('review');
        $listingId = $request->route('id') ?? $request->route('listing');
        $review = Review::findOrFail($reviewId);

        if ($review->author_id !== Auth::id()) {
            return redirect()->route('listings.show', $listingId)
                ->with('error', 'You are not the author of this review!');
        }

        return $next($request);
    }
}
