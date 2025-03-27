<?php

namespace App\Services;

use Carbon\Carbon;

class BookingPriceCalculationService
{

    public function calculatePrice($check_in, $check_out, $rooms, $services): int {
        $bookingPrice = 0;
        $bookingDuration = Carbon::parse($check_in)->diffInDays(Carbon::parse($check_out));
        $categories = $rooms->pluck('category');

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
