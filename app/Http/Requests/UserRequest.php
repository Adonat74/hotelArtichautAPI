<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'bail|required|email:rfc|unique:App\Models\User,email',
            'password' => 'bail|required|string|min:10',
            'firstname' => 'bail|required|string|max:50',
            'lastname' => 'bail|required|string|max:50',
            'address' => 'bail|required|string|max:70',
            'city' => 'bail|required|string|max:30',
            'postal_code' => 'bail|required|string|max:15',
            'phone' => 'bail|required|string|max:12',
            'is_pro' => 'bail|required|boolean',
            'image' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',// vérifie que les éléments sont des images
        ];
    }

    public $validator = null;
    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
