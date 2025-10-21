@extends('layouts.app')

@section('content')
    <style>
        /* Listing type badges */
        .listing-types {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .type-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 16px;
            background-color: rgba(255, 56, 92, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(255, 56, 92, 0.3);
        }

        .trending-badge {
            background-color: rgba(255, 165, 0, 0.1);
            color: #ff8c00;
            border-color: rgba(255, 165, 0, 0.3);
            font-weight: 600;
        }

        h3 {
            text-align: center;
        }

        .bookings-line {
            margin-bottom: 0;
            min-height: 2rem;
            display: flex;
            align-items: center;
        }

        .bookings-placeholder {
            display: inline-block;
            height: 2rem;
            visibility: hidden;
        }

        /* Book Now button outline effect */
        .btn-book-now {
            border: 1px solid #ff385c;
            background-color: transparent;
            font-size: 0.75rem;
            margin-left: 1rem;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-book-now:hover {
            background-color: #ff385c;
            color: white;
            border-color: #ff385c;
        }

        /* Show page responsive styles */
        @media (max-width: 992px) {
            .col-8.offset-2 {
                width: 90%;
                margin-left: 5%;
                margin-right: 5%;
            }
        }

        @media (max-width: 768px) {
            .col-8.offset-2 {
                width: 100%;
                margin-left: 0;
                margin-right: 0;
                padding: 0 1rem;
            }

            .btns {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btns .btn {
                width: 100%;
                margin: 0 !important;
            }

            .btns form {
                width: 100%;
            }

            h3.h3 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            h4 {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .col-8.offset-2 {
                padding: 0 0.5rem;
            }

            h3.h3 {
                font-size: 1.25rem;
                margin-bottom: 0.75rem;
            }

            h4 {
                font-size: 1.1rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .card-text {
                font-size: 0.9rem;
            }

            textarea.form-control {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }

            .type-badge {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }
        }
    </style>

    <script>
        const mapToken = "{{ config('services.mapbox.access_token') }}";
        const listing = @json($requireData);

        // Parse geometry_coordinates if it's a JSON string
        if (listing.geometry_coordinates && typeof listing.geometry_coordinates === 'string') {
            try {
                listing.geometry_coordinates = JSON.parse(listing.geometry_coordinates);
                // parse kori cz mysql string e store kortese coordinates amr lagbe array te 
            } catch (e) {
                console.error('Failed to parse coordinates:', e);
                listing.geometry_coordinates = [0, 0];
            }
        }
    </script>

    <div class="row container">
        <div class="col-8 offset-2">
            <h3 class="h3"><strong>{{ $requireData->title }}</strong></h3>

            <div class="card show-card">
                <img src="{{ $requireData->image_url }}" alt="Listing Image" class="show_image_card card-img-top" />
                <div class="index_show_card-body card-body mt-2">
                    <p class="card-text">
                        <strong>Owned by: {{ $requireData->owner->username }}</strong><br />
                        {{ $requireData->description }}<br />
                        &#2547; {{ number_format($requireData->price) }}<br />
                        {{ $requireData->country }}<br />
                        {{ $requireData->location }}
                    </p>

                    <!-- Listing er types gulo badge akare dekhabo -->
                    <div class="listing-types">
                        @if ($requireData->listing_type_1)
                            <span class="type-badge">{{ $requireData->listing_type_1 }}</span>
                        @endif
                        @if ($requireData->listing_type_2)
                            <span class="type-badge">{{ $requireData->listing_type_2 }}</span>
                        @endif
                        @if ($requireData->listing_type_3)
                            <span class="type-badge">{{ $requireData->listing_type_3 }}</span>
                        @endif
                    </div>

                    <!-- Booking count dekhabo jodi trending hoy -->
                    <div class="bookings-line">
                        @if ($requireData->trending_points > 0)
                            <span class="type-badge trending-badge">No of Bookings:
                                {{ $requireData->trending_points }}</span>
                        @else
                            <span class="bookings-placeholder">&nbsp;</span>
                        @endif
                    </div>
                </div>
            </div>
            @if ($currUser && $currUser->isGuest())
                {{-- Guest hole book korte parbe --}}
                <div class="mb-3">
                    <a href="{{ route('bookings.create', $requireData->id) }}" class="btn btn-book-now">
                        Book Now
                    </a>
                </div>
            @endif
        </div>

        <div class="card col-8 offset-2 mb-3 p-4" style="border-radius:2rem;">
            @if ($currUser && $currUser->isGuest())
                <h4>Leave a review</h4>

                <form action="{{ route('reviews.store', $requireData->id) }}" method="POST" novalidate
                    class="needs-validation">
                    @csrf
                    <div class="mt-3">
                        <label for="rating" class="form-label">Rating</label>
                        <fieldset class="starability-slot">
                            <input type="radio" id="no-rate" class="input-no-rate" name="review[rating]" value="1"
                                checked aria-label="No rating." />
                            <input type="radio" id="first-rate1" name="review[rating]" value="1" />
                            <label for="first-rate1" title="Terrible">1 star</label>
                            <input type="radio" id="first-rate2" name="review[rating]" value="2" />
                            <label for="first-rate2" title="Not good">2 stars</label>
                            <input type="radio" id="first-rate3" name="review[rating]" value="3" />
                            <label for="first-rate3" title="Average">3 stars</label>
                            <input type="radio" id="first-rate4" name="review[rating]" value="4" />
                            <label for="first-rate4" title="Very good">4 stars</label>
                            <input type="radio" id="first-rate5" name="review[rating]" value="5" />
                            <label for="first-rate5" title="Amazing">5 stars</label>
                        </fieldset>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea name="review[comment]" id="comment" cols="30" rows="4" class="form-control" required
                            style="resize: none;"></textarea>

                        <div class="valid-feedback">looks good!</div>
                        <div class="invalid-feedback">Please enter a valid comment</div>
                    </div>

                    <button class="btn btn-outline-dark mb-3">Submit</button>
                </form>
            @endif
            @if (count($requireData->reviews) === 0)
                <!-- Kono review nai ekhono -->
            @else
                <hr />
                <h4 class="mb-3">All Reviews</h4>

                <div class="row mt-3">
                    @foreach ($requireData->reviews as $review)
                        <div class="col-12 col-sm-6 col-md-5 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-2">
                                        {{ $review->author->username ?? 'Anonymous' }}
                                    </h5>
                                    <p class="starability-result card-text" data-rating="{{ $review->rating }}"></p>
                                    <p class="card-text mb-3">{{ $review->comment }}</p>

                                    @if ($currUser && $currUser->id === $review->author_id)
                                        <form class="mb-2" method="POST"
                                            action="{{ route('reviews.destroy', [$requireData->id, $review->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-dark">DELETE</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        <div class="col-8 offset-2 mb-5">
            <h4>Where you'll be</h4>
            <div id="map" class="mt-3"></div>
        </div>
    </div>

    <script src="{{ asset('js/map.js') }}"></script>
@endsection
