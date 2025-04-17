<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'check_in' => 'bail|required|date|after_or_equal:now',
            'check_out' => 'bail|required|date|after:check_in',
            'number_of_persons' => 'bail|required|integer',
            'rooms' => 'bail|required|array',
            'rooms.*' => 'bail|required|exists:rooms,id',
            'services' => 'nullable|array',
            'services.*' => 'nullable|exists:services,id',
        ];
    }
}
