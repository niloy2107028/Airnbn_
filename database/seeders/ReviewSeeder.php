<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates reviews from guest users for various listings
     * Ensures diverse ratings and realistic comments
     */
    public function run(): void
    {
        // Get all guest users
        $guests = User::where('role', 'guest')->get();

        // Get all listings
        $listings = Listing::all();

        if ($guests->isEmpty() || $listings->isEmpty()) {
            $this->command->warn('No guests or listings found. Run UserSeeder and ListingSeeder first.');
            return;
        }

        // Predefined review comments (Banglish style for variety)
        $reviewComments = [
            // 5-star reviews
            [
                'comment' => 'Amazing place! The host was very friendly and the location is perfect. Highly recommended!',
                'rating' => 5,
            ],
            [
                'comment' => 'Best stay ever! Clean, comfortable, and exactly as shown in pictures. Will definitely come back.',
                'rating' => 5,
            ],
            [
                'comment' => 'Absolutely loved it! Great amenities and very peaceful neighborhood. Thank you!',
                'rating' => 5,
            ],
            [
                'comment' => 'Perfect for a weekend getaway. The host was super responsive and helpful throughout.',
                'rating' => 5,
            ],

            // 4-star reviews
            [
                'comment' => 'Very good experience overall. Minor issues with WiFi but everything else was great!',
                'rating' => 4,
            ],
            [
                'comment' => 'Nice place, good location. Would have been 5 stars if the AC was a bit stronger.',
                'rating' => 4,
            ],
            [
                'comment' => 'Great value for money. Clean and cozy, just a bit far from public transport.',
                'rating' => 4,
            ],
            [
                'comment' => 'Enjoyed our stay! The bed was super comfortable. Only downside was limited parking.',
                'rating' => 4,
            ],

            // 3-star reviews
            [
                'comment' => 'Decent place, met our basic needs. Could use some updates to the furniture.',
                'rating' => 3,
            ],
            [
                'comment' => 'Average experience. Clean but a bit noisy at night due to traffic.',
                'rating' => 3,
            ],
            [
                'comment' => 'Okay for a short stay. Not much to do nearby but the place itself is fine.',
                'rating' => 3,
            ],

            // 4-5 star reviews (more variety)
            [
                'comment' => 'Wonderful host! They even left some snacks for us. Place was spotless and well-equipped.',
                'rating' => 5,
            ],
            [
                'comment' => 'Great location near restaurants and shops. The view from the balcony is beautiful!',
                'rating' => 5,
            ],
            [
                'comment' => 'Really enjoyed staying here. Host gave excellent local recommendations. Thumbs up!',
                'rating' => 4,
            ],
            [
                'comment' => 'Spacious and comfortable. Perfect for families. Kids loved it!',
                'rating' => 5,
            ],
            [
                'comment' => 'Good place for the price. Check-in was smooth and host was friendly.',
                'rating' => 4,
            ],
            [
                'comment' => 'Cozy apartment with all necessary amenities. Would recommend to friends!',
                'rating' => 4,
            ],
            [
                'comment' => 'Loved the interior design! Very Instagram-worthy. Great stay overall.',
                'rating' => 5,
            ],
            [
                'comment' => 'Quiet neighborhood, felt very safe. The kitchen was well-stocked with utensils.',
                'rating' => 4,
            ],
            [
                'comment' => 'Pleasant surprise! Much better than expected from the photos. Super clean!',
                'rating' => 5,
            ],
            [
                'comment' => 'Nice stay but bathroom could be cleaner. Otherwise everything was good.',
                'rating' => 3,
            ],
        ];

        // Create reviews - distribute among listings
        $reviewIndex = 0;

        // Each guest will write 6-7 reviews (total ~20 reviews across 28 listings)
        foreach ($guests as $guestIndex => $guest) {
            // Each guest reviews 6-7 different listings
            $reviewCount = ($guestIndex === 0) ? 7 : 6;

            for ($i = 0; $i < $reviewCount; $i++) {
                // Get a listing (distribute reviews across different listings)
                $listingIndex = ($guestIndex * 7 + $i) % $listings->count();
                $listing = $listings[$listingIndex];

                // Get review data
                $reviewData = $reviewComments[$reviewIndex % count($reviewComments)];

                // Create the review
                Review::create([
                    'comment' => $reviewData['comment'],
                    'rating' => $reviewData['rating'],
                    'author_id' => $guest->id,
                    'listing_id' => $listing->id,
                ]);

                $reviewIndex++;
            }
        }

        $this->command->info('✓ Created ' . $reviewIndex . ' reviews from ' . $guests->count() . ' guest users');
    }
}
