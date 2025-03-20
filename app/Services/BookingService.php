<?php

namespace App\Services;

use App\Models\Booking;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class BookingService
{
    public function checkRoomAvailability($id, $checkIn, $checkOut)
    {
//      get every booking that contains a given room
        $bookings = Booking::whereHas('rooms', function (Builder $query) use ($id) {
            $query->where('room_id', '=', $id);
        })->get();

//      check if the room dates are available
        foreach ($bookings as $booking) {
            if(
                $booking->check_in < $checkIn && $booking->check_out > $checkIn ||
                $booking->check_in < $checkOut && $booking->check_out > $checkOut ||
                $booking->check_in < $checkOut && $booking->check_out > $checkIn
            ){
                return false;
            }
        }
        return true;
    }
}
