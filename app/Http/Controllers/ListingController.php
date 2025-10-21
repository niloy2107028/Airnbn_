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


class ListingController extends Controller
{
    protected $geocodingService;

    public function __construct(MapboxGeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    /**
     * sob listings dekhabo
     */
    public function index(Request $request)
    {
        $query = Listing::query();
        //query builder obj banalam for listing model

        // user jodi kono location ba country search kore tahole oi condition gula check korbo
        if ($request->has('search') && !empty($request->search)) {
            // request theke search term ta nilam
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('location', 'like', '%' . $searchTerm . '%')
                    ->orWhere('country', 'like', '%' . $searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $searchTerm . '%');
            });
            //%paris% eta khujbe Paris, South Paris, or Paris Hotel egulake
        }

        // trending select korle trending_points onujayi sort hobe
        if ($request->has('type') && $request->type === 'Trending') {
            $query->orderBy('trending_points', 'desc');
        }
        // listing type onujayi filter korte hobe, 3 ta column e check korbo
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
     * create listing er form dekhabo
     */
    public function create()
    {
        // check korbo user host kina, na hole listing create korte dibo na
        if (!Auth::user()->isHost()) {
            //ishost is a function of user model
            return redirect()->route('listings.index')->with('error', 'Only hosts can create listings.');
        }

        // host 5 tar beshi listing banate parbe na, ota check korbo
        if (!Auth::user()->canCreateListing()) {
            return redirect()->route('listings.index')->with('error', 'You have reached the maximum limit of 5 listings.');
        }

        return view('listings.create');
    }

    /**
     * ekta listing er details dekhabo
     */
    public function show($id)
    {
        $requireData = Listing::with(['reviews.author', 'owner'])
            ->findOrFail($id);
        //Eager loading - loads the listing's reviews, each review's author, and the listing's owner all in one query (prevents N+1 problem)

        // trending point increase hobe only jokhn booking confirm hobe
        // view korle ar increment hobe na

        return view('listings.show', compact('requireData'));
    }

    /**
     * notun listing create kore database e save korbo
     */
    public function store(StoreListingRequest $request)
    {
        // abar check kore nilam host kina
        if (!Auth::user()->isHost()) {
            return redirect()->route('listings.index')->with('error', 'Only hosts can create listings.');
        }

        // 5 ta listing limit ache kina check
        if (!Auth::user()->canCreateListing()) {
            return redirect()->route('listings.index')->with('error', 'You have reached the maximum limit of 5 listings.');
        }

        $validated = $request->validated();

        // mapbox use kore location theke coordinates ber korbo
        $query = $validated['listing']['location'] . ', ' . $validated['listing']['country'];
        //location and country use kore Mapbox api e search korbo
        $geometry = $this->geocodingService->forwardGeocode($query, 1);
        //forward geocoding address theke coordinates dibe (lat.longitude) 1 means 1 tai result dibe besr match

        // image upload er jonno cloudinary use korbo
        $imageUrl = null;
        $imageFilename = null;

        if ($request->hasFile('listing.image') && $request->file('listing.image')->isValid()) {
            // is valid laravel er buitin method 
            $uploadedFile = $request->file('listing.image');

            Log::info('File upload attempt', [
                'has_file' => true,
                'is_valid' => true,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'size' => $uploadedFile->getSize(),
                'mime' => $uploadedFile->getMimeType()
            ]);

            try {
                // cloudinary te upload korlam
                $filename = 'airnbn_DEV/' . time() . '_' . $uploadedFile->getClientOriginalName();
                $path = Storage::disk('cloudinary')->putFileAs('airnbn_DEV', $uploadedFile, time() . '_' . $uploadedFile->getClientOriginalName());
                //pathe folder name and filename dibo time+original name mileye
                // cloudinary er URL banalam
                $cloudName = config('filesystems.disks.cloudinary.cloud');
                //config folder er filesystem file through te env theke cloude name anbe
                $imageUrl = "https://res.cloudinary.com/{$cloudName}/image/upload/{$path}";
                $imageFilename = $path;

                Log::info('Image uploaded successfully', [
                    'url' => $imageUrl,
                    'filename' => $imageFilename,
                    'path' => $path
                ]);
            } catch (\Exception $e) {
                // jodi upload fail kore tahole image chara listing banabo
                Log::warning('Cloudinary upload failed: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
                // user ke warning dekhabo
                session()->flash('warning', 'Image upload failed. Listing created without image.');
            }
        } else {
            Log::info('No file uploaded or file invalid', [
                'has_file' => $request->hasFile('listing.image'),
                'is_valid' => $request->hasFile('listing.image') && $request->file('listing.image')->isValid()
            ]);
        }

        // listing er data database e save korlam
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
     * listing edit korar form dekhabo
     */
    public function edit($id)
    {
        $requireData = Listing::findOrFail($id);
        //findOrFail() is a built-in Laravel Eloquent method.
        // automatically handles 404 (error handle er logic likh lagtese na)

        // image er URL ta ektu modify kore thumbnail er jonno
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
     * listing update korbo database e
     */
    public function update(StoreListingRequest $request, $id)
    {
        $validated = $request->validated();
        $listing = Listing::findOrFail($id);

        // location ba country change hole notun kore geocode korte hobe
        $locationChanged = $listing->location !== trim($validated['listing']['location']) ||
            $listing->country !== trim($validated['listing']['country']);

        if ($locationChanged) {
            $query = trim($validated['listing']['location']) . ', ' . trim($validated['listing']['country']);
            $geometry = $this->geocodingService->forwardGeocode($query, 1);

            $listing->geometry_type = $geometry['type'];
            $listing->geometry_coordinates = $geometry['coordinates'];
        }

        // listing er data update korbo
        $listing->fill($validated['listing']);

        // notun image thakle seta upload korbo
        if ($request->hasFile('listing.image') && $request->file('listing.image')->isValid()) {
            // Just checks $_FILES
            // File is already on server in temp location
            $uploadedFile = $request->file('listing.image');

            try {
                // cloudinary te notun image upload
                $path = Storage::disk('cloudinary')->putFileAs('airnbn_DEV', $uploadedFile, time() . '_' . $uploadedFile->getClientOriginalName());

                // URL banalam
                $cloudName = config('filesystems.disks.cloudinary.cloud');
                $listing->image_url = "https://res.cloudinary.com/{$cloudName}/image/upload/{$path}";
                $listing->image_filename = $path;

                Log::info('Image updated successfully', [
                    'url' => $listing->image_url,
                    'filename' => $listing->image_filename
                ]);
            } catch (\Exception $e) {
                // upload fail hole puran image e thakbe
                Log::warning('Cloudinary upload failed during update: ' . $e->getMessage());
                session()->flash('warning', 'Image upload failed. Listing updated without new image.');
            }
        }

        $listing->save();

        return redirect()->route('listings.show', $id)
            ->with('success', 'Listing Updated!');
    }

    /**
     * listing delete korbo
     * reviews auto delete hobe cascade kore
     */
    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return redirect()->route('listings.index')
            ->with('success', 'Listing Deleted!');
    }
}
