<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = Booking::all();
        $rooms = Room::all();


        for ($i = 0; $i < count($bookings)*0.5; $i++) {
            DB::table('booking_service')->insert([
                'booking_id' => $bookings->random()->id,
                'service_id' => $rooms->random()->id,
            ]);
        }
    }
}
