<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RoomsCategoryRequest extends FormRequest
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
            'category_name' => 'bail|required|string|max:255',
            'description' => 'bail|required|string|max:1000',
            'price_in_cent' => 'bail|required|integer',
            'bed_size' => 'bail|required|integer',
            'display_order' => 'bail|required|integer',
            'language_id' => 'bail|required|numeric|exists:languages,id',
            'rooms_features' => 'nullable|array', // Accepter un tableau de features
            'rooms_features.*' => 'nullable|exists:rooms_features,id', // Valider que chaque feature exist
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',
        ];
    }


    public $validator = null;
    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
