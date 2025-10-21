<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    //for fake date laravel's trait
    //but jodio factory use kori ni

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment',
        'rating',
        'author_id',
        'listing_id',
    ];
    // Laravel security feature that allows only these 4 columns to be mass-assigned via Review::create([...]) or $review->fill([...])
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime', // Explicitly cast createdAt equivalent
    ];

    /**
     * Get the author (user) of this review.
     * Equivalent to Mongoose populate('author')
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
        // Foreign key column in reviews table that references users.ids
        /* 
        $review->author returns the User who wrote this review
        $review->author->name gets the author's name
        Equivalent to SQL: SELECT * FROM users WHERE id = $review->author_id
        */
    }


    //  Get the listing this review belongs to.

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }
    //     belongsTo relationship - Many reviews belong to one listing
    // Listing::class - The related model
    // 'listing_id' - Foreign key in reviews table pointing to listings.id
    // Usage:
    // $review->listing gets the Listing this review is for
    // $review->listing->title gets the listing's title
    // Equivalent to SQL: SELECT * FROM listings WHERE id = $review->listing_id
}
