@extends('layouts.app')

@section('content')
    <!-- Select2 CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <!-- Loading overlay er style -->
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-content {
            text-align: center;
            color: white;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #fe424d;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 18px;
            font-weight: 500;
            margin-top: 10px;
        }

        .loading-subtext {
            font-size: 14px;
            color: #ddd;
            margin-top: 5px;
        }
    </style>

    <!-- Loading er overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="spinner"></div>
            <div class="loading-text">Updating your listing...</div>
            <div class="loading-subtext">Please wait, this may take a moment</div>
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2">
            <h3>Edit this Listing</h3>
            <form method="POST" action="{{ route('listings.update', $requireData->id) }}" class="needs-validation"
                novalidate enctype="multipart/form-data" id="editListingForm">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="listing[title]" value="{{ $requireData->title }}" placeholder="Enter title"
                        class="form-control" id="title" required />

                    <div class="valid-feedback">looks good!</div>
                    <div class="invalid-feedback">Please enter a valid tittle</div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="listing[description]" placeholder="Enter description" class="form-control" id="description" required>{{ $requireData->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Original Listing Image</label><br />
                    <img src="{{ $originalImageUrl }}" class="image_edit_preview img-fluid rounded shadow-sm mb-3"
                        alt="Listing Image" />
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Upload New Image</label>
                    <input type="file" name="listing[image]" class="form-control" id="image" />
                </div>

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="listing[price]" value="{{ $requireData->price }}"
                            placeholder="Enter price" class="form-control" id="price" required />
                    </div>

                    <div class="mb-3 col-md-8">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" name="listing[country]" value="{{ $requireData->country }}"
                            placeholder="Enter country" class="form-control" id="country" required />
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="listing[location]" value="{{ $requireData->location }}"
                        placeholder="Enter address" class="form-control" id="location" required />
                </div>

                <div class="mb-3">
                    <label for="listing_type_1" class="form-label">Listing Type 1 (Required)</label>
                    <select name="listing[listing_type_1]" class="form-control form-select listing-type-select"
                        id="listing_type_1" required>
                        <option value="" disabled>Select first category</option>
                        <option value="Rooms" {{ $requireData->listing_type_1 == 'Rooms' ? 'selected' : '' }}>🛏️ Rooms
                        </option>
                        <option value="Iconic Cities"
                            {{ $requireData->listing_type_1 == 'Iconic Cities' ? 'selected' : '' }}>🏙️ Iconic Cities
                        </option>
                        <option value="Mountain" {{ $requireData->listing_type_1 == 'Mountain' ? 'selected' : '' }}>⛰️
                            Mountain</option>
                        <option value="Cruises" {{ $requireData->listing_type_1 == 'Cruises' ? 'selected' : '' }}>🚢
                            Cruises</option>
                        <option value="Hiking" {{ $requireData->listing_type_1 == 'Hiking' ? 'selected' : '' }}>🥾 Hiking
                        </option>
                        <option value="Castle" {{ $requireData->listing_type_1 == 'Castle' ? 'selected' : '' }}>🏰 Castle
                        </option>
                        <option value="Heritage" {{ $requireData->listing_type_1 == 'Heritage' ? 'selected' : '' }}>🏛️
                            Heritage</option>
                        <option value="Landmarks" {{ $requireData->listing_type_1 == 'Landmarks' ? 'selected' : '' }}>🚩
                            Landmarks</option>
                        <option value="Towers" {{ $requireData->listing_type_1 == 'Towers' ? 'selected' : '' }}>🗼 Towers
                        </option>
                        <option value="Monuments" {{ $requireData->listing_type_1 == 'Monuments' ? 'selected' : '' }}>🗿
                            Monuments</option>
                        <option value="Bridges" {{ $requireData->listing_type_1 == 'Bridges' ? 'selected' : '' }}>🌉
                            Bridges</option>
                        <option value="Amazing Pools"
                            {{ $requireData->listing_type_1 == 'Amazing Pools' ? 'selected' : '' }}>🏊 Amazing Pools
                        </option>
                        <option value="Spa Retreats"
                            {{ $requireData->listing_type_1 == 'Spa Retreats' ? 'selected' : '' }}>🛁 Spa Retreats</option>
                        <option value="Lake Houses" {{ $requireData->listing_type_1 == 'Lake Houses' ? 'selected' : '' }}>
                            💧 Lake Houses</option>
                        <option value="Camping" {{ $requireData->listing_type_1 == 'Camping' ? 'selected' : '' }}>🌲
                            Camping</option>
                        <option value="Farms" {{ $requireData->listing_type_1 == 'Farms' ? 'selected' : '' }}>🐄 Farms
                        </option>
                        <option value="Arctic" {{ $requireData->listing_type_1 == 'Arctic' ? 'selected' : '' }}>❄️ Arctic
                        </option>
                        <option value="Beach" {{ $requireData->listing_type_1 == 'Beach' ? 'selected' : '' }}>🏖️ Beach
                        </option>
                        <option value="Private Pools"
                            {{ $requireData->listing_type_1 == 'Private Pools' ? 'selected' : '' }}>🪜 Private Pools
                        </option>
                        <option value="Tropical" {{ $requireData->listing_type_1 == 'Tropical' ? 'selected' : '' }}>⚡
                            Tropical</option>
                        <option value="Cabins" {{ $requireData->listing_type_1 == 'Cabins' ? 'selected' : '' }}>⛺ Cabins
                        </option>
                        <option value="NightView" {{ $requireData->listing_type_1 == 'NightView' ? 'selected' : '' }}>🌙
                            NightView</option>
                        <option value="Desert" {{ $requireData->listing_type_1 == 'Desert' ? 'selected' : '' }}>☀️ Desert
                        </option>
                    </select>
                    <div class="invalid-feedback">Please select first listing type</div>
                </div>

                <div class="mb-3">
                    <label for="listing_type_2" class="form-label">Listing Type 2 (Optional)</label>
                    <select name="listing[listing_type_2]" class="form-control form-select listing-type-select"
                        id="listing_type_2">
                        <option value="">Select second category (optional)</option>
                        <option value="Rooms" {{ $requireData->listing_type_2 == 'Rooms' ? 'selected' : '' }}>🛏️ Rooms
                        </option>
                        <option value="Iconic Cities"
                            {{ $requireData->listing_type_2 == 'Iconic Cities' ? 'selected' : '' }}>🏙️ Iconic Cities
                        </option>
                        <option value="Mountain" {{ $requireData->listing_type_2 == 'Mountain' ? 'selected' : '' }}>⛰️
                            Mountain</option>
                        <option value="Cruises" {{ $requireData->listing_type_2 == 'Cruises' ? 'selected' : '' }}>🚢
                            Cruises</option>
                        <option value="Hiking" {{ $requireData->listing_type_2 == 'Hiking' ? 'selected' : '' }}>🥾 Hiking
                        </option>
                        <option value="Castle" {{ $requireData->listing_type_2 == 'Castle' ? 'selected' : '' }}>🏰 Castle
                        </option>
                        <option value="Heritage" {{ $requireData->listing_type_2 == 'Heritage' ? 'selected' : '' }}>🏛️
                            Heritage</option>
                        <option value="Landmarks" {{ $requireData->listing_type_2 == 'Landmarks' ? 'selected' : '' }}>🚩
                            Landmarks</option>
                        <option value="Towers" {{ $requireData->listing_type_2 == 'Towers' ? 'selected' : '' }}>🗼 Towers
                        </option>
                        <option value="Monuments" {{ $requireData->listing_type_2 == 'Monuments' ? 'selected' : '' }}>🗿
                            Monuments</option>
                        <option value="Bridges" {{ $requireData->listing_type_2 == 'Bridges' ? 'selected' : '' }}>🌉
                            Bridges</option>
                        <option value="Amazing Pools"
                            {{ $requireData->listing_type_2 == 'Amazing Pools' ? 'selected' : '' }}>🏊 Amazing Pools
                        </option>
                        <option value="Spa Retreats"
                            {{ $requireData->listing_type_2 == 'Spa Retreats' ? 'selected' : '' }}>🛁 Spa Retreats</option>
                        <option value="Lake Houses" {{ $requireData->listing_type_2 == 'Lake Houses' ? 'selected' : '' }}>
                            💧 Lake Houses</option>
                        <option value="Camping" {{ $requireData->listing_type_2 == 'Camping' ? 'selected' : '' }}>🌲
                            Camping</option>
                        <option value="Farms" {{ $requireData->listing_type_2 == 'Farms' ? 'selected' : '' }}>🐄 Farms
                        </option>
                        <option value="Arctic" {{ $requireData->listing_type_2 == 'Arctic' ? 'selected' : '' }}>❄️ Arctic
                        </option>
                        <option value="Beach" {{ $requireData->listing_type_2 == 'Beach' ? 'selected' : '' }}>🏖️ Beach
                        </option>
                        <option value="Private Pools"
                            {{ $requireData->listing_type_2 == 'Private Pools' ? 'selected' : '' }}>🪜 Private Pools
                        </option>
                        <option value="Tropical" {{ $requireData->listing_type_2 == 'Tropical' ? 'selected' : '' }}>⚡
                            Tropical</option>
                        <option value="Cabins" {{ $requireData->listing_type_2 == 'Cabins' ? 'selected' : '' }}>⛺ Cabins
                        </option>
                        <option value="NightView" {{ $requireData->listing_type_2 == 'NightView' ? 'selected' : '' }}>🌙
                            NightView</option>
                        <option value="Desert" {{ $requireData->listing_type_2 == 'Desert' ? 'selected' : '' }}>☀️ Desert
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="listing_type_3" class="form-label">Listing Type 3 (Optional)</label>
                    <select name="listing[listing_type_3]" class="form-control form-select listing-type-select"
                        id="listing_type_3">
                        <option value="">Select third category (optional)</option>
                        <option value="Rooms" {{ $requireData->listing_type_3 == 'Rooms' ? 'selected' : '' }}>🛏️ Rooms
                        </option>
                        <option value="Iconic Cities"
                            {{ $requireData->listing_type_3 == 'Iconic Cities' ? 'selected' : '' }}>🏙️ Iconic Cities
                        </option>
                        <option value="Mountain" {{ $requireData->listing_type_3 == 'Mountain' ? 'selected' : '' }}>⛰️
                            Mountain</option>
                        <option value="Cruises" {{ $requireData->listing_type_3 == 'Cruises' ? 'selected' : '' }}>🚢
                            Cruises</option>
                        <option value="Hiking" {{ $requireData->listing_type_3 == 'Hiking' ? 'selected' : '' }}>🥾 Hiking
                        </option>
                        <option value="Castle" {{ $requireData->listing_type_3 == 'Castle' ? 'selected' : '' }}>🏰 Castle
                        </option>
                        <option value="Heritage" {{ $requireData->listing_type_3 == 'Heritage' ? 'selected' : '' }}>🏛️
                            Heritage</option>
                        <option value="Landmarks" {{ $requireData->listing_type_3 == 'Landmarks' ? 'selected' : '' }}>🚩
                            Landmarks</option>
                        <option value="Towers" {{ $requireData->listing_type_3 == 'Towers' ? 'selected' : '' }}>🗼 Towers
                        </option>
                        <option value="Monuments" {{ $requireData->listing_type_3 == 'Monuments' ? 'selected' : '' }}>🗿
                            Monuments</option>
                        <option value="Bridges" {{ $requireData->listing_type_3 == 'Bridges' ? 'selected' : '' }}>🌉
                            Bridges</option>
                        <option value="Amazing Pools"
                            {{ $requireData->listing_type_3 == 'Amazing Pools' ? 'selected' : '' }}>🏊 Amazing Pools
                        </option>
                        <option value="Spa Retreats"
                            {{ $requireData->listing_type_3 == 'Spa Retreats' ? 'selected' : '' }}>🛁 Spa Retreats</option>
                        <option value="Lake Houses" {{ $requireData->listing_type_3 == 'Lake Houses' ? 'selected' : '' }}>
                            💧 Lake Houses</option>
                        <option value="Camping" {{ $requireData->listing_type_3 == 'Camping' ? 'selected' : '' }}>🌲
                            Camping</option>
                        <option value="Farms" {{ $requireData->listing_type_3 == 'Farms' ? 'selected' : '' }}>🐄 Farms
                        </option>
                        <option value="Arctic" {{ $requireData->listing_type_3 == 'Arctic' ? 'selected' : '' }}>❄️ Arctic
                        </option>
                        <option value="Beach" {{ $requireData->listing_type_3 == 'Beach' ? 'selected' : '' }}>🏖️ Beach
                        </option>
                        <option value="Private Pools"
                            {{ $requireData->listing_type_3 == 'Private Pools' ? 'selected' : '' }}>🪜 Private Pools
                        </option>
                        <option value="Tropical" {{ $requireData->listing_type_3 == 'Tropical' ? 'selected' : '' }}>⚡
                            Tropical</option>
                        <option value="Cabins" {{ $requireData->listing_type_3 == 'Cabins' ? 'selected' : '' }}>⛺ Cabins
                        </option>
                        <option value="NightView" {{ $requireData->listing_type_3 == 'NightView' ? 'selected' : '' }}>🌙
                            NightView</option>
                        <option value="Desert" {{ $requireData->listing_type_3 == 'Desert' ? 'selected' : '' }}>☀️ Desert
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary add-btn mt-3" id="submitBtn">
                    <span class="btn-text">Save Changes</span>
                    <span class="btn-spinner" style="display: none;">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Saving...
                    </span>
                </button>
                <br /><br />
            </form>
        </div>
    </div>

    <!-- Select2 JS link -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // listing type er dropdowns e search feature lagalam Select2 diye
            $('.listing-type-select').select2({
                theme: 'bootstrap-5',
                placeholder: 'Search and select a category',
                allowClear: true,
                width: '100%'
            });

            // submit hole loading animation dekhabo
            $('#editListingForm').on('submit', function(e) {
                // age validate kore nibo
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).addClass('was-validated');
                    return false;
                }

                // loading overlay ta dekhabo
                $('#loadingOverlay').addClass('active');

                // button disable kore spinner chalu korbo
                const submitBtn = $('#submitBtn');
                submitBtn.prop('disabled', true);
                submitBtn.find('.btn-text').hide();
                submitBtn.find('.btn-spinner').show();

                // jodi image upload korteche tahole different message dekhabo
                const imageInput = $('input[name="listing[image]"]');
                if (imageInput[0] && imageInput[0].files && imageInput[0].files.length > 0) {
                    $('.loading-text').text('Uploading new image to Cloudinary...');
                    $('.loading-subtext').text('This may take a few moments depending on your image size');
                } else {
                    $('.loading-text').text('Updating your listing...');
                    $('.loading-subtext').text('Please wait');
                }
            });

            // back button e click korle loading hide kore dibo
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    $('#loadingOverlay').removeClass('active');
                    const submitBtn = $('#submitBtn');
                    submitBtn.prop('disabled', false);
                    submitBtn.find('.btn-text').show();
                    submitBtn.find('.btn-spinner').hide();
                }
            });
        });
    </script>
@endsection
