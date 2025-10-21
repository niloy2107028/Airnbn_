@extends('layouts.app')

@section('content')
    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card listing_card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-4" style="color: #222222;">Book {{ $listing->title }}</h3>

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Listing er preview dekhabo -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                @if ($listing->image_url)
                                    <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}"
                                        class="img-fluid rounded">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image"
                                        class="img-fluid rounded">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h5>{{ $listing->title }}</h5>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-map-marker-alt"></i> {{ $listing->location }}
                                </p>
                                <p class="text-muted mb-1">
                                    &#2547; {{ number_format($listing->price, 2) }} / night
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-user"></i> Host: {{ $listing->owner->username }}
                                </p>
                            </div>
                        </div>

                        <hr>

                        <!-- Booking Form -->
                    </div>
                </div>

                <!-- Booking er form -->
                <form method="POST" action="{{ route('bookings.store', $listing->id) }}" class="needs-validation"
                    novalidate>
                    @csrf <div class="mb-3">
                        <label for="persons" class="form-label">Number of Guests</label>
                        <input type="number" class="form-control @error('persons') is-invalid @enderror" id="persons"
                            name="persons" value="{{ old('persons', 1) }}" min="1" max="20" required>
                        @error('persons')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="check_in_date" class="form-label">Check-in Date</label>
                            <input type="date" class="form-control @error('check_in_date') is-invalid @enderror"
                                id="check_in_date" name="check_in_date" value="{{ old('check_in_date') }}"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('check_in_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="check_out_date" class="form-label">Check-out Date</label>
                            <input type="date" class="form-control @error('check_out_date') is-invalid @enderror"
                                id="check_out_date" name="check_out_date" value="{{ old('check_out_date') }}"
                                min="{{ date('Y-m-d', strtotime('+2 days')) }}" required>
                            @error('check_out_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-outline-dark">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn add-btn" style="background-color: blue !important; color:white;">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- Loading er overlay -->
    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
        <div class="loading-content">
            <div class="spinner-border" role="status" style="width: 3rem; height: 3rem; color: #ff385c;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-light">Sending booking request...</p>
        </div>
    </div>

    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loading-content {
            text-align: center;
        }

        .listing_card {
            border-radius: 1rem !important;
        }
    </style>

    <script>
        document.getElementById('bookingForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        });

        // Update check-out date min when check-in changes
        document.getElementById('check_in_date').addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            checkInDate.setDate(checkInDate.getDate() + 1);
            const minCheckOut = checkInDate.toISOString().split('T')[0];
            document.getElementById('check_out_date').min = minCheckOut;
        });
    </script>
@endsection
