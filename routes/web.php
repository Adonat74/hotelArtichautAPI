<?php

use App\Http\Controllers\BookingManagementController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckTokenVersion;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'Sanitization'], function() {

    Route::get('/qr/reservation/{id}', function ($id) {
        $bookingData = Booking::with('services', 'rooms.category', 'user')->findOrFail($id);

        return view('bookingDetails', [
            "booking_check_in" => $bookingData->check_in,
            "booking_check_out" => $bookingData->check_out,
            "booking_price" => $bookingData->total_price_in_cent/100 . ' €',
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


    Route::prefix('booking-management')->controller(BookingManagementController::class)->group(function () {

    //    Route::get('/checkout/{id}', 'checkout')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class.':user']);
    //    Route::post('/checkout', 'afterPayment')->middleware(['auth:api', CheckTokenVersion::class, CheckRole::class.':user'])->name('credit-card');

        Route::get('/checkout/{id}', 'checkout');
        Route::post('/checkout', 'afterPayment')->name('credit-card');

    });

});
