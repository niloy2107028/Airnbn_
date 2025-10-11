@extends('layouts.app')

@section('content')
<style>
  :root {
    --primary-color: #fe424d;
    --light-border: #ddd;
    --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
  }

  .second-nav {
    display: flex;
    justify-content: space-between;
  }

  .scroll-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    padding: 0 1rem;
    width: 70%;
  }

  .tax-toggle-container {
    padding: 1rem 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .tax-toggle {
    display: flex;
    height: max-content;
    align-items: center;
    border: 1.5px solid var(--light-border);
    border-radius: 1.5rem;
    padding: 0.4rem 0.9rem;
    background-color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.85rem;
  }

  .tax-toggle:hover {
    border: 1.5px solid var(--primary-color);
    /* padding: calc(0.65rem - 1px) calc(1.25rem - 1px); */
  }

  .tax-toggle:hover .tax-info {
    color: var(--primary-color);
  }

  .tax-toggle:hover .form-check-label {
    color: var(--primary-color);
  }

  .tax-toggle .form-check-label {
    color: #333;
    font-weight: 500;
    font-size: 0.85rem;
    transition: color 0.3s ease;
  }

  .tax-toggle .form-check-input {
    cursor: pointer;
    width: 2.5rem;
    height: 1.25rem;
  }

  .tax-toggle .form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
  }

  .tax-info {
    display: none;
    font-size: 0.8rem;
    color: #777;
    transition: color 0.3s ease;
  }

  .reset-filter-wrapper {
    position: absolute;
    top: -8px;
    right: -8px;
    z-index: 20;
  }

  .reset-filter-btn {
    font-size: 0.7rem;
    background: var(--primary-color);
    border: 2px solid white;
    border-radius: 50%;
    height: 1.5rem;
    width: 1.5rem;
    color: white !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    text-decoration: none;
  }

  .reset-filter-btn:hover {
    background-color: #d63447;
    transform: scale(1.1);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
    color: white !important;
  }

  .reset-filter-btn i {
    color: white !important;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }

  .scroll-btn-wrapper {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
  }

  .scroll-btn-wrapper.left-wrapper {
    left: -5px;
  }

  .scroll-btn-wrapper.right-wrapper {
    right: -5px;
  }

  .scroll-btn {
    font-size: 1.1rem;
    background: white;
    border: 2px solid var(--primary-color);
    border-radius: 50%;
    height: 2.5rem;
    width: 2.65rem;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .scroll-btn i {
    color: var(--primary-color);
  }

  .scroll-btn:hover {
    background-color: var(--primary-color);
  }

  .scroll-btn:hover i {
    color: white;
  }

  .scroll-inner {
    flex: 1;
    overflow-x: auto;
    scroll-behavior: smooth;
    scrollbar-width: none;
    margin: 0 2.5rem;
  }

  .scroll-inner::-webkit-scrollbar {
    display: none;
  }

  #filters {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    align-items: center;
    width: max-content;
  }

  .filter {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    height: 70px;
    width: 70px;
    min-width: 80px;
    border-radius: 12px;
    border: 1px solid var(--light-border);
    background-color: white;
    box-shadow: var(--box-shadow);
    transition: transform 0.2s ease, opacity 0.2s, border 0.2s ease, background-color 0.2s ease;
  }

  .filter i {
    font-size: 16px;
    margin-bottom: 6px;
    color: var(--primary-color);
  }

  .filter p {
    font-size: 12px;
    margin: 0;
    color: #333;
    /* color: var(--primary-color); */
  }

  .filter > a {
    text-decoration: none;
    color: inherit;
  }

  .filter:hover {
    transform: translateY(-3px);
    opacity: 0.9;
    cursor: pointer;
    background-color: rgba(255, 56, 92, 0.1);
  }

  /* Selected filter state */
  .filter-selected {
    background-color: rgba(255, 56, 92, 0.1) !important;
    border: 2px solid var(--primary-color) !important;
    transform: translateY(-3px);
  }

  .filter-selected i,
  .filter-selected p {
    font-weight: 600;
  }

  .listing-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
  }

  .listing_card {
    transition: transform 0.2s ease;
    box-shadow: var(--box-shadow);
    border: none;
    border-radius: 12px;
    overflow: hidden;
  }

  .listing_card:hover {
    transform: translateY(-4px);
  }

  .index_image_card {
    border-radius: 12px !important;
    height: 15rem !important;
    object-fit: cover !important;
    /* border-bottom: 1px solid #eee; */
    width: 100% !important;
  }

  .index_show_card-body {
    padding: 1rem;
  }

  .card-img-overlay {
    opacity: 0;
}

h3 {
    text-align: center;
}

.card-img-overlay:hover {
    opacity: 0.1;
    background-color: white;
}


  .card-title {
    font-size: 1.1rem;
    font-weight: 600;
  }
  .card-text p {
    font-weight: 400 !important;
}

  .listing-country {
    font-size: 0.9rem;
    color: #666;
    /* margin:; */
    display: flex;
    align-items: center;
    gap: 0.4rem;
  }

  .listing-country i {
    color: var(--primary-color);
    font-size: 0.85rem;
  }

  .listing-types {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-top: 0.5rem;
  }

  .type-badge {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: 12px;
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

  .bookings-line {
    margin-top: 0.5rem;
    min-height: 1.8rem;
    display: flex;
    align-items: center;
  }

  .bookings-placeholder {
    display: inline-block;
    height: 1.8rem;
    visibility: hidden;
  }

  /* Search Results Info Styles */
  .search-results-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.25rem 0.5rem;
    background: linear-gradient(135deg, #fe424d 0%, #ff6b7a 100%);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(254, 66, 77, 0.25);
    color: white;
    margin-bottom: 0.75rem;
    flex-wrap: wrap;
    gap: 0.75rem;
  }

  .search-info-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
    min-width: 200px;
    font-size: 0.9rem;
  }

  .search-info-content i {
    font-size: 1rem;
    opacity: 0.9;
  }

  .results-count {
    opacity: 0.85;
    font-size: 0.85rem;
    margin-left: 0.25rem;
  }

  .clear-search-btn {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.1rem 0.8rem;
    margin:0.25rem 0;
    background: transparent;
    border: 2px solid white;
    border-radius: 20px;
    color: white;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
  }

  .clear-search-btn:hover {
    background: white;
    border-color: white;
    color: var(--primary-color);
    /* transform: scale(1.05); */
  }

  .clear-search-btn i {
    font-size: 0.8rem;
  }

  /* Index page optimized layout */
  .row.row-cols-xl-4 {
    margin-left: 0;
    margin-right: 0;
  }

  .row.row-cols-xl-4 > * {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }

  /* No Results Styles */
  .no-results-container {
    text-align: center;
    padding: 4rem 2rem;
    margin: 2rem 0;
  }

  .no-results-icon {
    font-size: 4rem;
    color: var(--light-border);
    margin-bottom: 1.5rem;
    opacity: 0.6;
  }

  .no-results-title {
    font-size: 1.75rem;
    color: var(--text-dark, #333);
    margin-bottom: 1rem;
    font-weight: 600;
  }

  .no-results-text {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 2rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
  }

  .no-results-actions .btn {
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  /* ✅ Extra Large Screens - 4 columns */
  @media (min-width: 1200px) {
    .row.row-cols-xl-4 > * {
      flex: 0 0 25%;
      max-width: 25%;
    }
  }

  /* ✅ Responsive Adjustments */
  @media (max-width: 992px) {
    .second-nav {
      flex-direction: column;
      gap: 0.5rem;
    }

    .scroll-wrapper {
      width: 100%;
      padding: 0 0.5rem;
    }

    .search-results-info {
      padding: 0.6rem 0.875rem;
      flex-direction: column;
      align-items: flex-start;
      gap: 0.6rem;
    }

    .search-info-content {
      min-width: 100%;
      flex-wrap: wrap;
      font-size: 0.85rem;
    }

    .clear-search-btn {
      align-self: stretch;
      justify-content: center;
    }

    .reset-filter-wrapper {
      top: -6px;
      right: -6px;
    }

    .reset-filter-btn {
      font-size: 0.65rem;
      height: 1.3rem;
      width: 1.3rem;
    }

    .scroll-inner {
      margin: 0 1.5rem;
    }

    .scroll-btn {
      font-size: 1rem;
      height: 2rem;
      width: 2.2rem;
    }

    .filter {
      width: 80px;
      min-width: 80px;
      padding: 10px;
      height: 65px;
    }

    .filter i {
      font-size: 18px;
    }

    .filter p {
      font-size: 11px;
    }

    .tax-toggle-container {
      padding: 0.5rem 1rem;
      width: 100%;
    }

    .tax-toggle {
      padding: 0.5rem 1rem;
    }

    .index_image_card {
      height: 220px;
    }
  }

  @media (max-width: 768px) {
    .second-nav {
      padding: 0.5rem 0;
    }

    .scroll-wrapper {
      padding: 0;
    }

    .search-results-info {
      padding: 0.55rem 0.75rem;
    }

    .search-info-content {
      font-size: 0.8rem;
    }

    .search-info-content i {
      font-size: 0.95rem;
    }

    .results-count {
      font-size: 0.75rem;
    }

    .reset-filter-wrapper {
      top: -5px;
      right: -5px;
    }

    .reset-filter-btn {
      font-size: 0.6rem;
      height: 1.2rem;
      width: 1.2rem;
    }

    .scroll-btn-wrapper.left-wrapper {
      left: 0;
    }

    .scroll-btn-wrapper.right-wrapper {
      right: 0;
    }

    .scroll-btn {
      font-size: 0.9rem;
      height: 1.8rem;
      width: 2rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .filter {
      width: 70px;
      min-width: 70px;
      padding: 8px;
      height: 60px;
    }

    .filter i {
      font-size: 16px;
      margin-bottom: 4px;
    }

    .filter p {
      font-size: 10px;
    }

    #filters {
      gap: 0.75rem;
      padding: 0.75rem 0;
    }

    .listing_card {
      margin-bottom: 1.25rem;
    }

    .index_image_card {
      height: 200px;
    }

    .card-title {
      font-size: 1rem;
    }

    .card-text {
      font-size: 0.95rem;
    }
  }

  @media (max-width: 576px) {
    .second-nav {
      padding: 0.25rem 0;
    }

    .scroll-btn-wrapper {
      display: none;
    }

    .scroll-inner {
      margin: 0;
      padding: 0 0.5rem;
    }

    .filter {
      width: 65px;
      min-width: 65px;
      padding: 6px;
      height: 55px;
    }

    .filter i {
      font-size: 14px;
      margin-bottom: 3px;
    }

    .filter p {
      font-size: 9px;
    }

    #filters {
      gap: 0.5rem;
      padding: 0.5rem 0;
    }

    .tax-toggle-container {
      padding: 0.5rem;
    }

    .tax-toggle {
      padding: 0.4rem 0.8rem;
      font-size: 0.9rem;
    }

    .tax-toggle .form-check-label {
      font-size: 0.9rem;
    }

    .listing_card {
      margin: 0.75rem auto;
      border-radius: 10px;
    }

    .index_image_card {
      height: 180px;
      border-radius: 10px 10px 0 0;
    }

    .index_show_card-body {
      padding: 0.75rem;
    }

    .card-title {
      font-size: 0.95rem;
      margin-bottom: 0.5rem;
    }

    .card-text {
      font-size: 0.85rem;
    }
  }

  @media (max-width: 400px) {
    .filter {
      width: 60px;
      min-width: 60px;
      height: 50px;
      padding: 5px;
    }

    .filter i {
      font-size: 12px;
      margin-bottom: 2px;
    }

    .filter p {
      font-size: 8px;
    }

    #filters {
      gap: 0.4rem;
    }

    .index_image_card {
      height: 160px;
    }

    .card-title {
      font-size: 0.9rem;
    }

    .card-text {
      font-size: 0.8rem;
    }
  }


  /* Responsive: Better mobile layout */
  @media (max-width: 576px) {
    .container-fluid, .row {
      padding-left: 0 !important;
      padding-right: 0 !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
    }

    .row > .col {
      padding-left: 0.25rem !important;
      padding-right: 0.25rem !important;
    }
  }
</style>

<!-- === Scroll Filters Section === -->
<div class="second-nav">
  <div class="scroll-wrapper">
    <div class="scroll-btn-wrapper left-wrapper">
      <button class="scroll-btn left" onclick="scrollFiltersLeft()">
        <i class="fa-solid fa-chevron-left"></i>
      </button>
    </div>

    <div class="scroll-inner" id="scroll-container">
      <div id="filters">
        @php
        $icons = [
          ["fa-fire", "Trending"],
          ["fa-bed", "Rooms"],
          ["fa-city", "Iconic Cities"],
          ["fa-mountain", "Mountain"],
          ["fa-ship", "Cruises"],
          ["fa-person-hiking", "Hiking"],
          ["fa-chess-rook", "Castle"],
          ["fa-building-columns", "Heritage"],
          ["fa-landmark-flag", "Landmarks"],
          ["fa-tower-observation", "Towers"],
          ["fa-monument", "Monuments"],
          ["fa-bridge", "Bridges"],
          ["fa-person-swimming", "Amazing Pools"],
          ["fa-hot-tub-person", "Spa Retreats"],
          ["fa-water", "Lake Houses"],
          ["fa-tree", "Camping"],
          ["fa-cow", "Farms"],
          ["fa-snowflake", "Arctic"],
          ["fa-umbrella-beach", "Beach"],
          ["fa-water-ladder", "Private Pools"],
          ["fa-bolt", "Tropical"],
          ["fa-campground", "Cabins"],
          ["fa-moon", "NightView"],
          ["fa-sun", "Desert"]
        ];
        $selectedType = $selectedType ?? 'all';
        @endphp
        @foreach($icons as [$icon, $label])
        <div class="filter {{ $selectedType === $label ? 'filter-selected' : '' }}">
          <a href="{{ route('listings.index', array_merge(request()->query(), ['type' => $label])) }}" 
             style="text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; height: 100%;">
            <i class="fa-solid {{ $icon }}"></i>
            <p>{{ $label }}</p>
          </a>
          
          @if($selectedType === $label)
          <div class="reset-filter-wrapper">
            <a href="{{ route('listings.index', request()->only('search')) }}" class="reset-filter-btn" onclick="event.stopPropagation();">
              <b>X</b>
            </a>
          </div>
          @endif
        </div>
        @endforeach
      </div>
    </div>

    <div class="scroll-btn-wrapper right-wrapper">
      <button class="scroll-btn right" onclick="scrollFiltersRight()">
        <i class="fa-solid fa-chevron-right"></i>
      </button>
    </div>
  </div>

  <div class="tax-toggle-container">
    <div class="tax-toggle">
      <div class="form-check-reverse form-switch">
        <input
          class="form-check-input"
          type="checkbox"
          role="switch"
          id="flexSwitchCheckDefault"
        />
        <label class="form-check-label" for="flexSwitchCheckDefault">
         Taxes&nbsp;&nbsp;
        </label>
      </div>
    </div>
  </div>
</div>

<!-- === Search Results Info === -->
@if(!empty($searchQuery))
<div class="container-fluid mt-3 px-2">
  <div class="search-results-info">
    <div class="search-info-content">
      <span>Search results for : <strong>"{{ $searchQuery }}"</strong></span>
      <span class="results-count">({{ count($arrayOfListingData) }} {{ count($arrayOfListingData) == 1 ? 'listing' : 'listings' }} found)</span>
    </div>
    <a href="{{ route('listings.index') }}" class="clear-search-btn">
      <i class="fa-solid fa-xmark"></i>
      Clear search
    </a>
  </div>
</div>
@endif

<!-- === Listings Grid === -->
<div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 mt-3 px-2">
  @if(count($arrayOfListingData) > 0)
    @foreach($arrayOfListingData as $data)
    <div class="col mb-3">
      <a href="{{ route('listings.show', $data->id) }}" class="listing-link">
        <div class="card listing_card h-100">
        <img
          src="{{ $data->image_url }}"
          class="index_image_card card-img-top"
          alt="listing img"
        />
        <div class="card-img-overlay"></div>
        <div class="index_show_card-body card-body">
        <h5 class="card-title">{{ $data->title }}</h5>
        <p class="card-text">
          &#2547; {{ number_format($data->price) }}/night
          <span class="tax-info">&nbsp;&nbsp;+18% VAT</span>
        </p>
        
        <!-- Country Name -->
        <p class="listing-country">
          <i class="fa-solid fa-location-dot"></i>
          {{ $data->country }}
        </p>
        
        <!-- Listing Types Badges -->
        <div class="listing-types">
          @if($data->listing_type_1)
            <span class="type-badge">{{ $data->listing_type_1 }}</span>
          @endif
          @if($data->listing_type_2)
            <span class="type-badge">{{ $data->listing_type_2 }}</span>
          @endif
          @if($data->listing_type_3)
            <span class="type-badge">{{ $data->listing_type_3 }}</span>
          @endif
        </div>
        
        <!-- Trending/Bookings Badge - Always on new line -->
        <div class="bookings-line">
          @if($data->trending_points > 0)
            <span class="type-badge trending-badge">Number of bookings : {{ $data->trending_points }}</span>
          @else
            <span class="bookings-placeholder">&nbsp;</span>
          @endif
        </div>
      </div>
        </div>
      </a>
    </div>
  @endforeach
  @else
  <!-- No Results Found -->
  <div class="col-12">
    <div class="no-results-container">
      <div class="no-results-icon">
        <i class="fa-solid fa-magnifying-glass"></i>
      </div>
      <h3 class="no-results-title">No listings found</h3>
      <p class="no-results-text">
        @if(!empty($searchQuery))
          We couldn't find any listings matching "<strong>{{ $searchQuery }}</strong>"
        @else
          No listings available at the moment.
        @endif
      </p>
      <div class="no-results-actions">
        @if(!empty($searchQuery))
        <a href="{{ route('listings.index') }}" class="btn btn-primary">
          <i class="fa-solid fa-arrow-left"></i>
          View all listings
        </a>
        @endif
      </div>
    </div>
  </div>
  @endif
</div>

<!-- === Scroll + Toggle Script === -->
<script>
  const scrollContainer = document.getElementById("scroll-container");
  const scrollByAmount = 300;

  function scrollFiltersLeft() {
    scrollContainer.scrollBy({ left: -scrollByAmount, behavior: "smooth" });
  }

  function scrollFiltersRight() {
    scrollContainer.scrollBy({ left: scrollByAmount, behavior: "smooth" });
  }

  const taxSwitch = document.getElementById("flexSwitchCheckDefault");
  taxSwitch.addEventListener("click", () => {
    const taxInfoElements = document.getElementsByClassName("tax-info");
    for (let info of taxInfoElements) {
      info.style.display = info.style.display === "inline" ? "none" : "inline";
    }
  });
</script>
@endsection
