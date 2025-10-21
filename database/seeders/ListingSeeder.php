<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use App\Services\MapboxGeocodingService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $geocodingService = new MapboxGeocodingService();

        // Get all host users for round-robin distribution
        $hosts = User::where('role', 'host')->get();

        if ($hosts->isEmpty()) {
            $this->command->error('No host users found. Run UserSeeder first.');
            return;
        }

        $this->command->info("Found {$hosts->count()} host users for listing distribution.");

        // Sample listings data
        $sampleListings = [
            [
                'title' => 'Cozy Beachfront Cottage',
                'description' => 'Escape to this charming beachfront cottage for a relaxing getaway. Enjoy stunning ocean views and easy access to the beach.',
                'image_url' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHRyYXZlbHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1500,
                'location' => 'Malibu',
                'country' => 'United States',
                'listing_type_1' => 'Beach',
                'listing_type_2' => 'Tropical',
                'listing_type_3' => null,
                'trending_points' => 25,
            ],
            [
                'title' => 'Modern Loft in Downtown',
                'description' => 'Stay in the heart of the city in this stylish loft apartment. Perfect for urban explorers!',
                'image_url' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fHRyYXZlbHxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1200,
                'location' => 'New York City',
                'country' => 'United States',
                'listing_type_1' => 'Iconic Cities',
                'listing_type_2' => 'Rooms',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Mountain Retreat',
                'description' => 'Unplug and unwind in this peaceful mountain cabin. Surrounded by nature, it\'s a perfect place to recharge.',
                'image_url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8aG90ZWxzfGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1000,
                'location' => 'Aspen',
                'country' => 'United States',
                'listing_type_1' => 'Mountain',
                'listing_type_2' => 'Cabins',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Historic Villa in Tuscany',
                'description' => 'Experience the charm of Tuscany in this beautifully restored villa. Explore the rolling hills and vineyards.',
                'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aG90ZWxzfGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 2500,
                'location' => 'Florence',
                'country' => 'Italy',
                'listing_type_1' => 'Heritage',
                'listing_type_2' => 'Landmarks',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Secluded Treehouse Getaway',
                'description' => 'Live among the treetops in this unique treehouse retreat. A true nature lover\'s paradise.',
                'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fGhvdGVsc3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 800,
                'location' => 'Portland',
                'country' => 'United States',
                'listing_type_1' => 'Camping',
                'listing_type_2' => 'Hiking',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Beachfront Paradise',
                'description' => 'Step out of your door onto the sandy beach. This beachfront condo offers the ultimate relaxation.',
                'image_url' => 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fGhvdGVsc3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 2000,
                'location' => 'Cancun',
                'country' => 'Mexico',
                'listing_type_1' => 'Beach',
                'listing_type_2' => 'Tropical',
                'listing_type_3' => 'Amazing Pools',
                'trending_points' => 42,
            ],
            [
                'title' => 'Rustic Cabin by the Lake',
                'description' => 'Spend your days fishing and kayaking on the serene lake. This cozy cabin is perfect for outdoor enthusiasts.',
                'image_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fG1vdW50YWlufGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 900,
                'location' => 'Lake Tahoe',
                'country' => 'United States',
                'listing_type_1' => 'Lake Houses',
                'listing_type_2' => 'Cabins',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Luxury Penthouse with City Views',
                'description' => 'Indulge in luxury living with panoramic city views from this stunning penthouse apartment.',
                'image_url' => 'https://images.unsplash.com/photo-1622396481328-9b1b78cdd9fd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8c2t5JTIwdmFjYXRpb258ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 3500,
                'location' => 'Los Angeles',
                'country' => 'United States',
                'listing_type_1' => 'Iconic Cities',
                'listing_type_2' => 'NightView',
                'listing_type_3' => 'Rooms',
            ],
            [
                'title' => 'Ski-In/Ski-Out Chalet',
                'description' => 'Hit the slopes right from your doorstep in this ski-in/ski-out chalet in the Swiss Alps.',
                'image_url' => 'https://images.unsplash.com/photo-1502784444187-359ac186c5bb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fHNreSUyMHZhY2F0aW9ufGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 3000,
                'location' => 'Verbier',
                'country' => 'Switzerland',
                'listing_type_1' => 'Mountain',
                'listing_type_2' => 'Cabins',
                'listing_type_3' => 'Arctic',
            ],
            [
                'title' => 'Safari Lodge in the Serengeti',
                'description' => 'Experience the thrill of the wild in a comfortable safari lodge. Witness the Great Migration up close.',
                'image_url' => 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mjl8fG1vdW50YWlufGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 4000,
                'location' => 'Serengeti National Park',
                'country' => 'Tanzania',
                'listing_type_1' => 'Camping',
                'listing_type_2' => 'Hiking',
                'listing_type_3' => 'Farms',
                'trending_points' => 18,
            ],
            [
                'title' => 'Historic Canal House',
                'description' => 'Stay in a piece of history in this beautifully preserved canal house in Amsterdam\'s iconic district.',
                'image_url' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FtcGluZ3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1800,
                'location' => 'Amsterdam',
                'country' => 'Netherlands',
                'listing_type_1' => 'Heritage',
                'listing_type_2' => 'Bridges',
                'listing_type_3' => 'Landmarks',
            ],
            [
                'title' => 'Private Island Retreat',
                'description' => 'Have an entire island to yourself for a truly exclusive and unforgettable vacation experience.',
                'image_url' => 'https://images.unsplash.com/photo-1618140052121-39fc6db33972?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bG9kZ2V8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 10000,
                'location' => 'Fiji',
                'country' => 'Fiji',
                'listing_type_1' => 'Beach',
                'listing_type_2' => 'Tropical',
                'listing_type_3' => 'Private Pools',
            ],
            [
                'title' => 'Charming Cottage in the Cotswolds',
                'description' => 'Escape to the picturesque Cotswolds in this quaint and charming cottage with a thatched roof.',
                'image_url' => 'https://images.unsplash.com/photo-1602088113235-229c19758e9f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8YmVhY2glMjB2YWNhdGlvbnxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1200,
                'location' => 'Cotswolds',
                'country' => 'United Kingdom',
                'listing_type_1' => 'Farms',
                'listing_type_2' => 'Heritage',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Historic Brownstone in Boston',
                'description' => 'Step back in time in this elegant historic brownstone located in the heart of Boston.',
                'image_url' => 'https://images.unsplash.com/photo-1533619239233-6280475a633a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTR8fHNreSUyMHZhY2F0aW9ufGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 2200,
                'location' => 'Boston',
                'country' => 'United States',
                'listing_type_1' => 'Heritage',
                'listing_type_2' => 'Iconic Cities',
                'listing_type_3' => 'Landmarks',
            ],
            [
                'title' => 'Beachfront Bungalow in Bali',
                'description' => 'Relax on the sandy shores of Bali in this beautiful beachfront bungalow with a private pool.',
                'image_url' => 'https://images.unsplash.com/photo-1602391833977-358a52198938?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MzJ8fGNhbXBpbmd8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1800,
                'location' => 'Bali',
                'country' => 'Indonesia',
                'listing_type_1' => 'Private Pools',
                'listing_type_2' => 'Beach',
                'listing_type_3' => 'Tropical',
            ],
            [
                'title' => 'Mountain View Cabin in Banff',
                'description' => 'Enjoy breathtaking mountain views from this cozy cabin in the Canadian Rockies.',
                'image_url' => 'https://images.unsplash.com/photo-1521401830884-6c03c1c87ebb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGxvZGdlfGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1500,
                'location' => 'Banff',
                'country' => 'Canada',
                'listing_type_1' => 'Cabins',
                'listing_type_2' => 'Mountain',
                'listing_type_3' => 'Camping',
            ],
            [
                'title' => 'Art Deco Apartment in Miami',
                'description' => 'Step into the glamour of the 1920s in this stylish Art Deco apartment in South Beach.',
                'image_url' => 'https://plus.unsplash.com/premium_photo-1670963964797-942df1804579?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTZ8fGxvZGdlfGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1600,
                'location' => 'Miami',
                'country' => 'United States',
                'listing_type_1' => 'Rooms',
                'listing_type_2' => 'Beach',
                'listing_type_3' => 'Iconic Cities',
            ],
            [
                'title' => 'Tropical Villa in Phuket',
                'description' => 'Escape to a tropical paradise in this luxurious villa with a private infinity pool in Phuket.',
                'image_url' => 'https://images.unsplash.com/photo-1470165301023-58dab8118cc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fGxvZGdlfGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 3000,
                'location' => 'Phuket',
                'country' => 'Thailand',
                'listing_type_1' => 'Tropical',
                'listing_type_2' => 'Private Pools',
                'listing_type_3' => 'Beach',
            ],
            [
                'title' => 'Historic Castle in Scotland',
                'description' => 'Live like royalty in this historic castle in the Scottish Highlands. Explore the rugged beauty of the area.',
                'image_url' => 'https://images.unsplash.com/photo-1585543805890-6051f7829f98?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fGJlYWNoJTIwdmFjYXRpb258ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 4000,
                'location' => 'Scottish Highlands',
                'country' => 'United Kingdom',
                'listing_type_1' => 'Castle',
                'listing_type_2' => 'Heritage',
                'listing_type_3' => 'Landmarks',
            ],
            [
                'title' => 'Desert Oasis in Dubai',
                'description' => 'Experience luxury in the middle of the desert in this opulent oasis in Dubai with a private pool.',
                'image_url' => 'https://images.unsplash.com/photo-1518684079-3c830dcef090?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8ZHViYWl8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 5000,
                'location' => 'Dubai',
                'country' => 'United Arab Emirates',
                'listing_type_1' => 'Desert',
                'listing_type_2' => 'Private Pools',
                'listing_type_3' => 'Spa Retreats',
                'trending_points' => 35,
            ],
            [
                'title' => 'Rustic Log Cabin in Montana',
                'description' => 'Unplug and unwind in this cozy log cabin surrounded by the natural beauty of Montana.',
                'image_url' => 'https://images.unsplash.com/photo-1586375300773-8384e3e4916f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTN8fGxvZGdlfGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1100,
                'location' => 'Montana',
                'country' => 'United States',
                'listing_type_1' => 'Cabins',
                'listing_type_2' => 'Mountain',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Beachfront Villa in Greece',
                'description' => 'Enjoy the crystal-clear waters of the Mediterranean in this beautiful beachfront villa on a Greek island.',
                'image_url' => 'https://images.unsplash.com/photo-1602343168117-bb8ffe3e2e9f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8dmlsbGF8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 2500,
                'location' => 'Mykonos',
                'country' => 'Greece',
                'listing_type_1' => 'Beach',
                'listing_type_2' => 'Amazing Pools',
                'listing_type_3' => 'Landmarks',
            ],
            [
                'title' => 'Eco-Friendly Treehouse Retreat',
                'description' => 'Stay in an eco-friendly treehouse nestled in the forest. It\'s the perfect escape for nature lovers.',
                'image_url' => 'https://images.unsplash.com/photo-1488462237308-ecaa28b729d7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8c2t5JTIwdmFjYXRpb258ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 750,
                'location' => 'Costa Rica',
                'country' => 'Costa Rica',
                'listing_type_1' => 'Camping',
                'listing_type_2' => 'Tropical',
                'listing_type_3' => 'Hiking',
            ],
            [
                'title' => 'Historic Cottage in Charleston',
                'description' => 'Experience the charm of historic Charleston in this beautifully restored cottage with a private garden.',
                'image_url' => 'https://images.unsplash.com/photo-1587381420270-3e1a5b9e6904?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGxvZGdlfGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1600,
                'location' => 'Charleston',
                'country' => 'United States',
                'listing_type_1' => 'Heritage',
                'listing_type_2' => 'Landmarks',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Modern Apartment in Tokyo',
                'description' => 'Explore the vibrant city of Tokyo from this modern and centrally located apartment.',
                'image_url' => 'https://images.unsplash.com/photo-1480796927426-f609979314bd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fHRva3lvfGVufDB8fDB8fHww&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 2000,
                'location' => 'Tokyo',
                'country' => 'Japan',
                'listing_type_1' => 'Iconic Cities',
                'listing_type_2' => 'Rooms',
                'listing_type_3' => 'NightView',
            ],
            [
                'title' => 'Lakefront Cabin in New Hampshire',
                'description' => 'Spend your days by the lake in this cozy cabin in the scenic White Mountains of New Hampshire.',
                'image_url' => 'https://images.unsplash.com/photo-1578645510447-e20b4311e3ce?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NDF8fGNhbXBpbmd8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1200,
                'location' => 'New Hampshire',
                'country' => 'United States',
                'listing_type_1' => 'Lake Houses',
                'listing_type_2' => 'Cabins',
                'listing_type_3' => null,
            ],
            [
                'title' => 'Luxury Villa in the Maldives',
                'description' => 'Indulge in luxury in this overwater villa in the Maldives with stunning views of the Indian Ocean.',
                'image_url' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bGFrZXxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 6000,
                'location' => 'Maldives',
                'country' => 'Maldives',
                'listing_type_1' => 'Amazing Pools',
                'listing_type_2' => 'Beach',
                'listing_type_3' => 'Tropical',
            ],
            [
                'title' => 'Ski Chalet in Aspen',
                'description' => 'Hit the slopes in style with this luxurious ski chalet in the world-famous Aspen ski resort.',
                'image_url' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTh8fGxha2V8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 4000,
                'location' => 'Aspen',
                'country' => 'United States',
                'listing_type_1' => 'Mountain',
                'listing_type_2' => 'Cabins',
                'listing_type_3' => 'Arctic',
            ],
            [
                'title' => 'Secluded Beach House in Costa Rica',
                'description' => 'Escape to a secluded beach house on the Pacific coast of Costa Rica. Surf, relax, and unwind.',
                'image_url' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YmVhY2glMjBob3VzZXxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=800&q=60',
                'image_filename' => 'listingimage',
                'price' => 1800,
                'location' => 'Costa Rica',
                'country' => 'Costa Rica',
                'listing_type_1' => 'Beach',
                'listing_type_2' => 'Camping',
                'listing_type_3' => 'Tropical',
            ],
        ];

        $this->command->info('Seeding listings with geocoding...');

        // Loop through sample listings and geocode each one
        // Distribute listings evenly among hosts (round-robin)
        $count = 0;
        foreach ($sampleListings as $listingData) {
            $this->command->info("Processing listing " . ($count + 1) . ": {$listingData['title']}");

            // Perform forward geocoding
            $query = "{$listingData['location']}, {$listingData['country']}";
            $geometry = $geocodingService->forwardGeocode($query);

            // Assign to host using round-robin (each host gets max 5 listings)
            $hostIndex = $count % $hosts->count();
            $currentHost = $hosts[$hostIndex];

            // Create listing with geocoded coordinates
            Listing::create([
                'title' => $listingData['title'],
                'description' => $listingData['description'],
                'image_url' => $listingData['image_url'],
                'image_filename' => $listingData['image_filename'],
                'price' => $listingData['price'],
                'location' => $listingData['location'],
                'country' => $listingData['country'],
                'geometry_type' => $geometry['type'],
                'geometry_coordinates' => json_encode($geometry['coordinates']),
                'listing_type_1' => $listingData['listing_type_1'] ?? null,
                'listing_type_2' => $listingData['listing_type_2'] ?? null,
                'listing_type_3' => $listingData['listing_type_3'] ?? null,
                'trending_points' => $listingData['trending_points'] ?? 0,
                'owner_id' => $currentHost->id,
            ]);

            $count++;
        }

        $this->command->info('Listings seeded successfully!');
    }
}
