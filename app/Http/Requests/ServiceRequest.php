<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'title' => 'bail|required|string|max:50',
            'short_description' => 'bail|required|string|max:200',
            'description' => 'bail|required|string|max:1000',
            'link' => 'nullable|string|max:50',
            'price_in_cent' => 'bail|required|numeric|min:0',
            'duration_in_day' => 'bail|required|numeric|min:1',
            'is_per_person' => 'bail|nullable|boolean',
            'display_order' => 'bail|required|integer',
            'language_id' => 'bail|required|numeric|exists:languages,id',
            'images' => 'nullable|array',// vérifie que c'est un tableau
            'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',// vérifie que les éléments sont des images
        ];
    }
}
