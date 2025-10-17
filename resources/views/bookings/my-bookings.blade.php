@extends('layouts.app')

@section('content')
    <style>
        .status-badge-confirmed {
            background-color: #00a699 !important;
            color: white;
        }

        .status-badge-pending {
            background-color: #ffb400 !important;
            color: white;
        }

        .status-badge-rejected {
            background-color: #fe424d !important;
            color: white;
        }

        .status-badge-cancelled {
            background-color: #6c757d !important;
            color: white;
        }

        .btn-cancel-booking {
            border: 1px solid #fe424d;
            color: #fe424d;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .btn-cancel-booking:hover {
            background-color: #fe424d;
            color: white;
            border-color: #fe424d;
        }

        .outline-btn {
            /* display: inline-block;
                            padding: 4px 16px; */
            border: 1px solid #0d6efd;
            /* blue outline */
            color: #0d6efd;
            /* border-radius: 6px; */
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .outline-btn:hover {
            background-color: #0d6efd;
            color: white;
        }
    </style>

    <div class="container mt-4">
        <h3 class="mb-4" style="color: #222222; text-align:center;">My Bookings</h3>
        <h3 class="mb-4" style="color: #222222;">Welcome, {{ $hostName }}</h3>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($bookings->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> You haven't made any bookings yet.
                <a href="{{ route('listings.index') }}" class="alert-link">Browse listings</a> to make your first booking!
            </div>
        @else
            <div class="row">
                @foreach ($bookings as $booking)
                    <div class="col-md-6 mb-4">
                        <div class="card listing_card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0" style="color: #222222;">{{ $booking->listing->title }}</h5>
                                    <span class="badge status-badge-{{ $booking->status }}"
                                        style="padding: 0.4rem 0.8rem; border-radius: 0.5rem;">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-5">
                                        @if ($booking->listing->image_url)
                                            <img src="{{ $booking->listing->image_url }}"
                                                alt="{{ $booking->listing->title }}" class="img-fluid"
                                                style="border-radius: 0.75rem; max-height: 100px; object-fit: cover;">
                                        @else
                                            <img src="https://via.placeholder.com/200x150?text=No+Image" alt="No Image"
                                                class="img-fluid" style="border-radius: 0.75rem;">
                                        @endif


                                    </div>
                                    <div class="col-7">
                                        <p class="mb-2 small">
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                            {{ $booking->listing->location }}
                                        </p>
                                        <p class="mb-2 small">
                                            <i class="fas fa-calendar-check text-muted"></i>
                                            {{ $booking->check_in_date->format('M d') }} -
                                            {{ $booking->check_out_date->format('M d, Y') }}
                                        </p>
                                        <p class="mb-2 small">
                                            <i class="fas fa-users text-muted"></i>
                                            {{ $booking->persons }} {{ Str::plural('guest', $booking->persons) }}
                                        </p>
                                        <p class="mb-0 small">

                                            &#2547;{{ number_format($booking->listing->price * $booking->check_in_date->diffInDays($booking->check_out_date), 2) }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('listings.show', $booking->listing_id) }}"
                                    class="btn outline-btn">Listing</a>

                                @if (in_array($booking->status, ['pending', 'confirmed']))
                                    <div class="d-flex justify-content-end">
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-cancel-booking">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
