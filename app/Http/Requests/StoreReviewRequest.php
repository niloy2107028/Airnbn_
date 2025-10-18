<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'review.rating' => 'required|integer|min:1|max:5',
            'review.comment' => 'required|string',
        ];
    }


    public function messages(): array
    {
        return [
            'review.rating.required' => 'Rating is required',
            'review.rating.min' => 'Rating must be at least 1',
            'review.rating.max' => 'Rating must be at most 5',
            'review.comment.required' => 'Comment is required',
        ];
    }
}
