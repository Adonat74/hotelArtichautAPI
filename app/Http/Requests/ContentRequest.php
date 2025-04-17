<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:100',
            'title' => 'bail|required|string|max:50',
            'short_description' => 'bail|required|string|max:200',
            'description' => 'bail|required|string|max:1000',
            'landing_page_display' => 'bail|required|boolean',
            'navbar_display' => 'bail|required|boolean',
            'link' => 'nullable|string',
            'display_order' => 'bail|required|integer',
            'language_id' => 'bail|required|numeric|exists:languages,id',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',
        ];
    }
}
