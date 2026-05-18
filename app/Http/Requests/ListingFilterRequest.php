<?php

namespace App\Http\Requests;

use App\Models\Listing;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListingFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:20'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'gte:price_min'],
            'size' => ['nullable', Rule::in(Listing::SIZE_OPTIONS)],
            'condition' => ['nullable', Rule::in(Listing::CONDITION_OPTIONS)],
            'sort' => ['nullable', Rule::in(Listing::SORT_OPTIONS)],
        ];
    }

    public function validatedFilters(): array
    {
        return array_filter(
            $this->validated(),
            fn (mixed $value): bool => $value !== null && $value !== ''
        );
    }
}
