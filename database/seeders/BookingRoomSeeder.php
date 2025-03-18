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


        for ($i = 0; $i < count($bookings)+10; $i++) {
            DB::table('booking_room')->insert([
                'booking_id' => $bookings->random()->id,
                'room_id' => $rooms->random()->id,
            ]);
        }
    }
}
