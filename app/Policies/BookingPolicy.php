<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking): bool
    {
        if ($user->id !== $booking->user_id) {
            return false;
        }
        if($booking->check_in <= now()) {
            throw new Exception("It's too late to update booking");
        }
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        if ($user->id !== $booking->user_id) {
            return false;
        }
        if($booking->check_in <= now()) {
            throw new Exception("It's too late to delete booking");
        }
        return true;
    }
}
