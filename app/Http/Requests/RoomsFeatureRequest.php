<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomsFeatureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:50',
            'feature_name' => 'bail|required|string|max:100',
            'description' => 'bail|required|string|max:1000',
            'display_order' => 'bail|required|integer',
            'language_id' => 'bail|required|numeric|exists:languages,id',
            'rooms_categories' => 'nullable|array',  // Validation des catégories
            'rooms_categories.*' => 'nullable|exists:rooms_categories,id',
        ];
    }
}
