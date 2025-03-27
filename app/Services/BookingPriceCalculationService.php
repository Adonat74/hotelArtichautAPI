<?php

namespace App\Services;

use Carbon\Carbon;

class BookingPriceCalculationService
{
    public function calculatePrice($booking): int {
        $bookingPrice = 0;
        $bookingDuration = Carbon::parse($booking->check_in)->diffInDays(Carbon::parse($booking->check_out));
        $categories = $booking->rooms->pluck('category');
        $services = $booking->services;

//      Calcul du prix des chambre par le nombre de jours
        foreach ($categories as $category) {
            $bookingPrice += $category->price_in_cent * $bookingDuration;
        }

//      Calcul du prix des servicespar la durée du séjour
        foreach ($services as $service) {
            $bookingPrice += $service->price_in_cent;
        }

        return $bookingPrice;
    }
}
