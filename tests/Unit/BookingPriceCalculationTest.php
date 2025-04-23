<?php

namespace Tests\Unit;

use App\Models\Room;
use App\Models\Service;
use App\Services\BookingPriceCalculationService;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class BookingPriceCalculationTest extends TestCase
{

    public function test_booking_price_calculation(): void
    {
        $room1 = (object)[
            'category' => (object)['price_in_cent' => 25000],
        ];
        $room2 = (object)[
            'category' => (object)['price_in_cent' => 54900],
        ];
        $rooms = new Collection([$room1, $room2]);

        $service1 = (object)['price_in_cent' =>  10000]; // €50/day
        $service2 = (object)['price_in_cent' =>  80000]; // €75/day
        $services = new Collection([$service1, $service2]);



        $service = new BookingPriceCalculationService;

        $this->assertEquals(849500, $service->calculatePrice("2025-01-01", "2025-01-06", $rooms, $services));
    }
}
