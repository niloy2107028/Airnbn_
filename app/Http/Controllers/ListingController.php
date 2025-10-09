<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListingRequest;
use App\Models\Listing;
use App\Services\MapboxGeocodingService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Listing Controller
 * Ported from Node.js controllers/listingController.js
 */
class ListingController extends Controller
{
    protected $geocodingService;

    public function __construct(MapboxGeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    /**
     * Index - Show all listings
     * Node.js: module.exports.index
     */
    public function index(Request $request)
    {
        $query = Listing::query();

        // Search by destination (location or country)
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('location', 'like', '%' . $searchTerm . '%')
                    ->orWhere('country', 'like', '%' . $searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $searchTerm . '%');
            });
        }

        // Special handling for Trending filter - sort by trending_points
        if ($request->has('type') && $request->type === 'Trending') {
            $query->orderBy('trending_points', 'desc');
        }
        // Filter by listing type if provided - check all three type columns
        elseif ($request->has('type') && $request->type !== 'all') {
            $query->where(function ($q) use ($request) {
                $q->where('listing_type_1', $request->type)
                    ->orWhere('listing_type_2', $request->type)
                    ->orWhere('listing_type_3', $request->type);
            });
        }

        $arrayOfListingData = $query->get();
        $selectedType = $request->get('type', 'all');
        $searchQuery = $request->get('search', '');

        return view('listings.index', compact('arrayOfListingData', 'selectedType', 'searchQuery'));
    }

    /**
     * Show create form
     * Node.js: module.exports.renderNewListingForm
     */
    public function create()
    {
        // Only hosts can create listings
        if (!Auth::user()->isHost()) {
            return redirect()->route('listings.index')->with('error', 'Only hosts can create listings.');
        }

        // Check if host has reached listing limit
        if (!Auth::user()->canCreateListing()) {
            return redirect()->route('listings.index')->with('error', 'You have reached the maximum limit of 5 listings.');
        }

        return view('listings.create');
    }

    /**
     * Show single listing
     * Node.js: module.exports.showListing
     */
    public function show($id)
    {
        $requireData = Listing::with(['reviews.author', 'owner'])
            ->findOrFail($id);

        // Increment trending points if user is authenticated
        if (Auth::check()) {
            $requireData->incrementTrendingPoints();
        }

        return view('listings.show', compact('requireData'));
    }

    /**
     * Store new listing
     * Node.js: module.exports.createListing
     */
    public function store(StoreListingRequest $request)
    {
        // Only hosts can create listings
        if (!Auth::user()->isHost()) {
            return redirect()->route('listings.index')->with('error', 'Only hosts can create listings.');
        }

        // Check if host has reached listing limit
        if (!Auth::user()->canCreateListing()) {
            return redirect()->route('listings.index')->with('error', 'You have reached the maximum limit of 5 listings.');
        }

        $validated = $request->validated();

        // Geocode the location
        $query = $validated['listing']['location'] . ', ' . $validated['listing']['country'];
        $geometry = $this->geocodingService->forwardGeocode($query, 1);

        // Handle file upload to Cloudinary
        $imageUrl = null;
        $imageFilename = null;

        if ($request->hasFile('listing.image') && $request->file('listing.image')->isValid()) {
            $uploadedFile = $request->file('listing.image');

            Log::info('File upload attempt', [
                'has_file' => true,
                'is_valid' => true,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'size' => $uploadedFile->getSize(),
                'mime' => $uploadedFile->getMimeType()
            ]);

            try {
                // Upload to Cloudinary using Storage disk
                $path = Storage::disk('cloudinary')->putFileAs('airnbn_DEV', $uploadedFile, time() . '_' . $uploadedFile->getClientOriginalName());

                // Get the full URL from Cloudinary
                $cloudName = config('filesystems.disks.cloudinary.cloud');
                $imageUrl = "https://res.cloudinary.com/{$cloudName}/image/upload/{$path}";
                $imageFilename = $path;

                Log::info('Image uploaded successfully', [
                    'url' => $imageUrl,
                    'filename' => $imageFilename,
                    'path' => $path
                ]);
            } catch (\Exception $e) {
                // Log the error but continue without image
                Log::warning('Cloudinary upload failed: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
                // Optionally flash an error message
                session()->flash('warning', 'Image upload failed. Listing created without image.');
            }
        } else {
            Log::info('No file uploaded or file invalid', [
                'has_file' => $request->hasFile('listing.image'),
                'is_valid' => $request->hasFile('listing.image') && $request->file('listing.image')->isValid()
            ]);
        }

        // Create new listing
        $listing = new Listing($validated['listing']);
        $listing->owner_id = Auth::id();
        $listing->image_url = $imageUrl;
        $listing->image_filename = $imageFilename;
        $listing->geometry_type = $geometry['type'];
        $listing->geometry_coordinates = $geometry['coordinates'];
        $listing->save();

        return redirect()->route('listings.index')
            ->with('success', 'New Listing Created!');
    }

    /**
     * Show edit form
     * Node.js: module.exports.renderEditForm
     */
    public function edit($id)
    {
        $requireData = Listing::findOrFail($id);

        // Image URL manipulation for thumbnail preview
        // Node.js: originalImageUrl.replace("/upload", "/upload/c_fill,w_250/bo_5px_solid_lightblue")
        $originalImageUrl = $requireData->image_url;
        if ($originalImageUrl) {
            $originalImageUrl = str_replace(
                '/upload',
                '/upload/c_fill,w_250/bo_5px_solid_lightblue',
                $originalImageUrl
            );
        }

        return view('listings.edit', compact('requireData', 'originalImageUrl'));
    }

    /**
     * Update listing
     * Node.js: module.exports.updateListing
     */
    public function update(StoreListingRequest $request, $id)
    {
        $validated = $request->validated();
        $listing = Listing::findOrFail($id);

        // Check if location or country changed for conditional geocoding
        $locationChanged = $listing->location !== trim($validated['listing']['location']) ||
            $listing->country !== trim($validated['listing']['country']);

        if ($locationChanged) {
            $query = trim($validated['listing']['location']) . ', ' . trim($validated['listing']['country']);
            $geometry = $this->geocodingService->forwardGeocode($query, 1);

            $listing->geometry_type = $geometry['type'];
            $listing->geometry_coordinates = $geometry['coordinates'];
        }

        // Update listing fields
        $listing->fill($validated['listing']);

        // Handle new image upload if provided
        if ($request->hasFile('listing.image') && $request->file('listing.image')->isValid()) {
            $uploadedFile = $request->file('listing.image');

            try {
                // Upload to Cloudinary using Storage disk
                $path = Storage::disk('cloudinary')->putFileAs('airnbn_DEV', $uploadedFile, time() . '_' . $uploadedFile->getClientOriginalName());

                // Get the full URL from Cloudinary
                $cloudName = config('filesystems.disks.cloudinary.cloud');
                $listing->image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$path}";
                $listing->image_filename = $path;

                Log::info('Image updated successfully', [
                    'url' => $listing->image_url,
                    'filename' => $listing->image_filename
                ]);
            } catch (\Exception $e) {
                // Log the error but continue with existing image
                Log::warning('Cloudinary upload failed during update: ' . $e->getMessage());
                session()->flash('warning', 'Image upload failed. Listing updated without new image.');
            }
        }

        $listing->save();

        return redirect()->route('listings.show', $id)
            ->with('success', 'Listing Updated!');
    }

    /**
     * Delete listing
     * Node.js: module.exports.deleteListing
     * Note: Reviews will be cascade deleted via Listing model's booted() method
     */
    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return redirect()->route('listings.index')
            ->with('success', 'Listing Deleted!');
    }
}
