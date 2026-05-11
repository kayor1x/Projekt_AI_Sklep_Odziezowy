<?php

namespace App\Http\Requests;

use App\Models\Listing;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:20', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:99999.99'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'condition' => ['required', Rule::in(Listing::CONDITION_OPTIONS)],
            'size' => ['required', Rule::in(Listing::SIZE_OPTIONS)],
            'images' => ['nullable', 'array', 'max:3'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
