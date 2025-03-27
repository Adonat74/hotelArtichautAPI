<?php

use App\Models\Booking;
use Illuminate\Support\Facades\Route;


Route::get('/qr/reservation/{id}', function ($id) {
    $bookingData = Booking::with('services', 'rooms.category', 'user')->findOrFail($id);

    return view('bookingDetails', [
        "booking_check_in" => $bookingData->check_in,
        "booking_check_out" => $bookingData->check_out,
        "booking_price" => $bookingData->total_price_in_cents/100 . ' €',
        "booking_number_person" => $bookingData->number_of_persons,
        "services" => $bookingData->services,

        "user_lastname" => $bookingData->user->lastname,
        "user_firstname" => $bookingData->user->firstname,
        "user_address" => $bookingData->user->address,
        "user_postal_code" => $bookingData->user->postal_code,
        "user_city" => $bookingData->user->city,
        "user_phone" => $bookingData->user->phone,
        "user_email" => $bookingData->user->email,
    ]);
});
