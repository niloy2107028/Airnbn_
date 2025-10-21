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

        .dashboard-card {
            border-radius: 1rem !important;
            border: 1px solid #ebebeb;
            overflow: hidden;
        }


        .dashboard-card-header {
            background-color: #6e6e6e;
            border-bottom: 1px solid #ebebeb;
            border-radius: 1rem 1rem 0 0 !important;
            padding: 1rem 1.5rem;
        }

        /* Outline button styles */
        .btn-outline-edit {
            border: 1px solid #222222;
            color: #222222;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-edit:hover {
            background-color: #222222;
            color: white;
            border-color: #222222;
        }

        .btn-outline-delete {
            border: 1px solid #fe424d;
            color: #fe424d;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-delete:hover {
            background-color: #fe424d;
            color: white;
            border-color: #fe424d;
        }
    </style>

    <div class="container mt-4">
        <h3 class="mb-4" style="color: #222222;text-align:center;">Host Dashboard</h3>
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

        <!-- Amar listings -->
        @endforeach
    </div>

    <!-- Pending bookings -->
    <div class="card dashboard-card mb-4 shadow-sm">
        <div class="dashboard-card-header">
            <h4 class="mb-0" style="color: white;">
                My Listings
                <span class="badge" style="background-color: #ebebeb; color: #222222;">{{ $myListings->count() }}/5</span>
                @if (auth()->user()->canCreateListing())
                    <a href="{{ route('listings.create') }}" class="btn btn-sm float-end add-btn"
                        style="background-color: #fe424d !important; color: white;">
                        Create New Listing
                    </a>
                @else
                    <span class="badge float-end" style="background-color: rgba(255, 56, 92, 0.8); color: white;">Maximum 5
                        listings
                        reached</span>
                @endif
            </h4>
        </div>
        <div class="card-body">
            @if ($myListings->isEmpty())
                <p class="text-muted mb-0">You haven't created any listings yet.
                    <a href="{{ route('listings.create') }}" style="color: #ff385c;">Create your first listing</a>
                </p>
            @else
                <div class="row">
                    @foreach ($myListings as $listing)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card listing_card h-100 shadow-sm">
                                @if ($listing->image_url)
                                    <img src="{{ $listing->image_url }}" class="card-img-top index_image_card"
                                        alt="{{ $listing->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/400x200?text=No+Image"
                                        class="card-img-top index_image_card" alt="No Image"
                                        style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #222222;">{{ $listing->title }}</h5>
                                    <p class="card-text" style="color: #717171;">
                                        <i class="fas fa-map-marker-alt"></i> {{ $listing->location }}
                                    </p>
                                    <p class="card-text" style="color: #222222;">
                                        <strong>&#2547;{{ number_format($listing->price, 2) }}</strong> <span
                                            style="color: #717171;">/ night</span>
                                    </p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('listings.edit', $listing->id) }}"
                                            class="btn btn-sm flex-fill btn-outline-edit">
                                            Edit
                                        </a>
                                        <form action="{{ route('listings.destroy', $listing->id) }}" method="POST"
                                            class="flex-fill"
                                            onsubmit="return confirm('Are you sure you want to delete this listing?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm w-100 btn-outline-delete">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Pending Bookings -->
    <div class="card dashboard-card mb-4 shadow-sm">
        <div class="dashboard-card-header" style="background-color: #6e6e6e;">
            <h4 class="mb-0" style="color: white;">
                Pending Bookings :
                <span class="badge"
                    style="background-color: #ebebeb; color: #222222;">{{ $pendingBookings->count() }}</span>
            </h4>
        </div>
        <div class="card-body">
            @if ($pendingBookings->isEmpty())
                <p class="text-muted mb-0">No pending bookings at the moment.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background-color: #f7f7f7;">
                            <tr style="color: #222222;">
                                <th>Guest</th>
                                <th>Listing</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Guests</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingBookings as $booking)
                                <tr style="color: #222222;">
                                    <td>{{ $booking->user->username }}</td>
                                    <td>{{ $booking->listing->title }}</td>
                                    <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                                    <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                                    <td>{{ $booking->persons }}</td>
                                    <td>
                                        <form action="{{ route('bookings.confirm', $booking) }}" method="POST"
                                            style="display: inline;" onsubmit="return confirm('Confirm this booking?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm"
                                                style="background-color: #00a699; color: white;" title="Confirm">
                                                Confirm
                                            </button>
                                        </form>
                                        <form action="{{ route('bookings.reject', $booking) }}" method="POST"
                                            style="display: inline; margin-left: 0.5rem;"
                                            onsubmit="return confirm('Reject this booking?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm"
                                                style="background-color: #fe424d; color: white;" title="Reject">
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>


    <!-- Sob bookings -->
    <div class="card dashboard-card shadow-sm">
        <div class="dashboard-card-header" style="background-color: #6e6e6e;">
            <h4 class="mb-0" style="color: white;">
                All Bookings
            </h4>
        </div>
        <div class="card-body">
            @if ($allBookings->isEmpty())
                <p class="text-muted mb-0">No bookings yet for your listings.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background-color: #f7f7f7;">
                            <tr style="color: #222222;">
                                <th>Guest</th>
                                <th>Listing</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Guests</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allBookings as $booking)
                                <tr style="color: #222222;">
                                    <td>{{ $booking->user->username }}</td>
                                    <td>{{ $booking->listing->title }}</td>
                                    <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                                    <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                                    <td>{{ $booking->persons }}</td>
                                    <td>
                                        <span class="badge status-badge-{{ $booking->status }}"
                                            style="padding: 0.4rem 0.8rem; border-radius: 0.5rem;">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection
