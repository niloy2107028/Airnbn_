# Airnbn Project Documentation

This is a Laravel-based Airbnb clone project. It provides a platform for hosts to list properties and guests to book them.

## Table of Contents

1. [Database Migrations, Factories, and Seeders](#1-database-migrations-factories-and-seeders)
2. [Controllers and Their Functions](#2-controllers-and-their-functions)
3. [Middlewares](#3-middlewares)
4. [Models](#4-models)
5. [Mapbox Services](#5-mapbox-services)
6. [Routes, Views, JS, and CSS](#6-routes-views-js-and-css)
7. [Necessary Artisan Commands](#7-necessary-artisan-commands)

## 1. Database Migrations, Factories, and Seeders

### Migrations

The project uses several migrations to set up the database schema:

-   **0001_01_01_000000_create_users_table.php**: Creates the `users` table with fields like `username`, `email`, `password`, `role` (guest/host).
-   **0001_01_01_000001_create_cache_table.php**: Creates cache table for Laravel caching.
-   **0001_01_01_000002_create_jobs_table.php**: Creates jobs table for background processing.
-   **2025_10_10_074319_create_listings_table.php**: Creates the `listings` table with fields like `title`, `description`, `image_url`, `price`, `location`, `country`, `geometry_type`, `geometry_coordinates`, `trending_points`, `listing_type_1/2/3`, `owner_id`.
-   **2025_10_10_074325_create_reviews_table.php**: Creates the `reviews` table with `comment`, `rating`, `author_id`, `listing_id`.
-   **2025_10_10_112754_add_multiple_listing_types_to_listings_table.php**: Adds multiple listing type columns.
-   **2025_10_10_120000_add_trending_and_type_to_listings_table.php**: Adds trending points and type fields.
-   **2025_10_17_105436_add_role_to_users_table.php**: Adds role column to users.
-   **2025_10_17_105453_create_bookings_table.php**: Creates `bookings` table with `listing_id`, `user_id`, `persons`, `check_in_date`, `check_out_date`, `status`, `special_requests`.
-   **2025_10_17_110439_update_existing_users_roles.php**: Updates existing users with roles.
-   **2025_10_17_111245_drop_unused_listing_type_column.php**: Cleans up unused columns.
-   **2025_10_17_112540_redistribute_listings_among_hosts.php**: Redistributes listings to hosts.

### Factories

-   **UserFactory.php**: Generates fake users with `name`, `email`, `password`, etc. Used for testing and seeding.

### Seeders

-   **DatabaseSeeder.php**: Calls `UserSeeder` and `ListingSeeder`.
-   **UserSeeder.php**: Creates 6 host users and 3 guest users with Bangladeshi names and default passwords.
-   **ListingSeeder.php**: Seeds 28 sample listings with geocoding using Mapbox. Distributes listings among hosts round-robin. Each listing includes title, description, image, price, location, country, types, and trending points.

## 2. Controllers and Their Functions

### AuthController

Handles user authentication:

-   `showSignupForm()`: Displays signup form.
-   `signup(Request $request)`: Validates and creates new user, auto-logs in.
-   `showLoginForm()`: Displays login form.
-   `login(Request $request)`: Authenticates user, redirects to intended URL.
-   `logout()`: Logs out user.

### ListingController

Manages listings:

-   `index(Request $request)`: Shows all listings, handles search and filtering by type/trending.
-   `create()`: Shows create listing form.
-   `store(StoreListingRequest $request)`: Validates, geocodes location, uploads image to Cloudinary, saves listing.
-   `show($id)`: Displays single listing with reviews.
-   `edit($id)`: Shows edit form.
-   `update(Request $request, $id)`: Updates listing with new data/image.
-   `destroy($id)`: Deletes listing and associated image.
-   `trackClick($id)`: Increments trending points for listing.

### BookingController

Handles bookings:

-   `create(Listing $listing)`: Shows booking form for guests.
-   `store(Request $request, Listing $listing)`: Creates new booking.
-   `show(Booking $booking)`: Displays booking details.
-   `myBookings()`: Shows guest's bookings.
-   `cancel(Booking $booking)`: Cancels booking (guest).
-   `hostDashboard()`: Shows host's dashboard with listings and bookings.
-   `confirm(Booking $booking)`: Confirms booking (host).
-   `reject(Booking $booking)`: Rejects booking (host).

### ReviewController

Manages reviews:

-   `store(StoreReviewRequest $request, $listingId)`: Creates new review for listing.
-   `destroy($listingId, $reviewId)`: Deletes review.

## 3. Middlewares

### EnsureListingOwner

Checks if authenticated user owns the listing. Used on edit/update/delete routes.

### EnsureReviewAuthor

Checks if authenticated user is the author of the review. Used on delete review route.

### SaveIntendedUrl

Saves the intended URL in session for redirect after login.

## 4. Models

### User

-   Relationships: `listings()` (hasMany), `bookings()` (hasMany), `reviews()` (hasMany).
-   Methods: `isHost()`, `isGuest()`, `hasActiveBooking()`, `canCreateListing()`, `pendingBookings()`.

### Listing

-   Relationships: `owner()` (belongsTo User), `reviews()` (hasMany), `bookings()` (hasMany).
-   Booted method: Deletes Cloudinary image on delete.

### Booking

-   Relationships: `listing()` (belongsTo), `user()` (belongsTo).
-   Methods: `isPending()`.

### Review

-   Relationships: `author()` (belongsTo User), `listing()` (belongsTo).

## 5. Mapbox Services

### MapboxGeocodingService

-   `__construct()`: Initializes Guzzle client and access token from config.
-   `forwardGeocode(string $query, int $limit = 1)`: Converts location query to coordinates using Mapbox API. Returns geometry array with type and coordinates. Handles errors with fallback [0,0].

Used in ListingController for geocoding locations during creation/update, and in ListingSeeder for seeding.

## 6. Routes, Views, JS, and CSS

### Routes (web.php)

-   **Root**: `GET /` -> `listings.index`
-   **Listings**: CRUD routes for listings, with auth middleware on create/store/edit/update/delete.
-   **Reviews**: POST `/listings/{id}/reviews` (store), DELETE `/listings/{id}/reviews/{reviewId}` (destroy), with auth.
-   **Auth**: GET/POST `/signup`, GET/POST `/login`, GET `/logout`.
-   **Bookings**: Guest routes (create, store, show, my-bookings, cancel), Host routes (host-dashboard, confirm, reject), all with auth.

### Views

-   **layouts/app.blade.php**: Main layout with navbar, content yield, footer.
-   **includes/navbar.blade.php**: Navigation bar with search, dark mode toggle, auth links.
-   **includes/footer.blade.php**: Footer with links, socials, developer credit.
-   **includes/floatingFlash.blade.php**: Flash messages.
-   **welcome.blade.php**: Welcome page (unused?).
-   **listings/index.blade.php**: Listings grid with search/filter.
-   **listings/show.blade.php**: Single listing with reviews/booking.
-   **listings/create.blade.php**: Create listing form.
-   **listings/edit.blade.php**: Edit listing form.
-   **bookings/create.blade.php**: Booking form.
-   **bookings/show.blade.php**: Booking details.
-   **bookings/my-bookings.blade.php**: Guest's bookings.
-   **bookings/host-dashboard.blade.php**: Host dashboard.
-   **auth/login.blade.php**: Login form.
-   **auth/signup.blade.php**: Signup form.

### JS

-   **public/js/script.js**: General scripts, possibly form handling.
-   **public/js/map.js**: Map integration (likely for listings).
-   **resources/js/app.js**: Main app JS.
-   **resources/js/bootstrap.js**: Bootstrap JS setup.

### CSS

-   **public/css/common.css**: Core styles for all pages (navbar, buttons, etc.).
-   **public/css/index.css**: Styles for listings index.
-   **public/css/show.css**: Styles for listing show page.
-   **public/css/forms.css**: Styles for forms.
-   **public/css/bookings.css**: Styles for booking pages.
-   **public/css/footer.css**: Footer styles.
-   **public/css/reviewStar.css**: Review star ratings.
-   **public/css/style.css**: Additional styles.
-   **resources/css/app.css**: Main app CSS.

Dark mode is implemented via body class toggle, with styles in common.css and others.

## 7. Necessary Artisan Commands

-   `php artisan migrate`: Run database migrations.
-   `php artisan db:seed`: Seed the database with users and listings.
-   `php artisan serve`: Start the development server.
-   `php artisan make:model ModelName`: Create a new model.
-   `php artisan make:controller ControllerName`: Create a new controller.
-   `php artisan make:migration migration_name`: Create a new migration.
-   `php artisan make:seeder SeederName`: Create a new seeder.
-   `php artisan make:middleware MiddlewareName`: Create a new middleware.
-   `php artisan make:request RequestName`: Create a new form request.
-   `php artisan route:list`: List all routes.
-   `php artisan tinker`: Interactive shell for testing code.

For production:

-   `php artisan config:cache`: Cache configuration.
-   `php artisan route:cache`: Cache routes.
-   `php artisan view:cache`: Cache views.
-   `php artisan migrate --seed`: Migrate and seed in one command.
