<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = Booking::all();
        $services = Service::all();


        for ($i = 0; $i < count($bookings)+5; $i++) {
            DB::table('booking_service')->insert([
                'booking_id' => $bookings->random()->id,
                'service_id' => $services->random()->id,
            ]);
        }
    }
}
