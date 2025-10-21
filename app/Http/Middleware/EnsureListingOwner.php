<?php

namespace App\Http\Middleware;

use App\Models\Listing;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureListingOwner
{
    /**
     * Handle an incoming request.
     * Checks if the authenticated user is the owner of the listing
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $listingId = $request->route('id') ?? $request->route('listing');
        $listing = Listing::findOrFail($listingId);

        if ($listing->owner_id !== Auth::id()) {
            return redirect()->route('listings.show', $listingId)
                ->with('error', 'You are not the owner of this listing!');
        }

        return $next($request);
    }
}
