<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminBookingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'check_in' => 'bail|required|date|after:today',
            'check_out' => 'bail|required|date|after:check_in',
            'total_price_in_cent' => 'bail|required|integer',
            'to_be_paid_in_cent' => 'bail|required|integer',
            'user_id' => 'bail|required|exists:users,id',
            'rooms' => 'bail|required|array',
            'rooms.*' => 'bail|required|exists:rooms,id',
            'services' => 'nullable|array',
            'services.*' => 'nullable|exists:services,id',
        ];
    }
}
