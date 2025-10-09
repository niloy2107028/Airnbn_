<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

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
    }

    /**
     * Get the listing this review belongs to.
     * Implicit in Mongo via parent doc, explicit foreign key in MySQL
     */
    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }
}
