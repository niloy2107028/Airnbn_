<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'listing.title' => 'required|string|max:255',
            'listing.description' => 'required|string',
            'listing.location' => 'required|string|max:255',
            'listing.country' => 'required|string|max:255',
            'listing.price' => 'required|numeric|min:0',
            'listing.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'listing.listing_type_1' => 'required|string|max:100',
            'listing.listing_type_2' => 'nullable|string|max:100',
            'listing.listing_type_3' => 'nullable|string|max:100',
        ];
    }


    public function messages(): array
    {
        return [
            'listing.title.required' => 'Title is required',
            'listing.description.required' => 'Description is required',
            'listing.location.required' => 'Location is required',
            'listing.country.required' => 'Country is required',
            'listing.price.required' => 'Price is required',
            'listing.price.min' => 'Price must be at least 0',
        ];
    }
}
