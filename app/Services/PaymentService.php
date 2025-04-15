<?php

namespace App\Services;

use App\Models\Booking;
use Exception;

class PaymentService
{
    public function checkPaymentAlreadyExist (Booking $booking):void {
        if ($booking->payments()->exists()) {
            throw new Exception("You already made a payment for this booking");
        }
    }
}
