<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'image_filename',
        'price',
        'location',
        'country',
        'geometry_type',
        'geometry_coordinates',
        'trending_points',
        'listing_type_1',
        'listing_type_2',
        'listing_type_3',
        'owner_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'geometry_coordinates' => 'array', // JSON column cast to array
        'price' => 'decimal:2',
        'trending_points' => 'integer',
    ];

    /**
     * Boot the model and set up event listeners.
     * Equivalent to Mongoose post middleware for findOneAndDelete
     */
    protected static function booted()
    {
        static::deleting(function ($listing) {
            // Delete all reviews associated with this listing
            // Equivalent to: await ReviewModel.deleteMany({ _id: { $in: deletedListing.reviews } });
            $listing->reviews()->delete();
        });
    }

    /**
     * Get the owner (user) of this listing.
     * Equivalent to Mongoose populate('owner')
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the reviews for this listing.
     * Equivalent to Mongoose reviews array with ObjectId refs
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'listing_id');
    }

    /**
     * Increment trending points when a logged-in user views the listing
     */
    public function incrementTrendingPoints()
    {
        $this->increment('trending_points');
    }
}
