<?php

namespace App\Services;

use Carbon\Carbon;

class BookingPriceCalculationService
{
    public function calculatePrice($booking): int {
        $bookingPrice = 0;
        $bookingDuration = Carbon::parse($booking->check_in)->diffInDays(Carbon::parse($booking->check_out));
        $categories = $booking->rooms->pluck('category');
        $services = $booking->services->pluck('service');


        foreach ($categories as $category) {
            $bookingPrice += $category->price_in_cent * $bookingDuration;
        }

        foreach ($services as $service) {
            if ($service->is_per_person) {
                $bookingPrice += $service->price_in_cent * $bookingDuration;
            }
            $bookingPrice += $service->price_in_cent * $bookingDuration;
        }




        return $bookingPrice;
    }
}
