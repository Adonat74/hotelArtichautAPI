<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeMail;
use App\Models\Booking;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingManagementController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/booking-management/qr-code",
     *     summary="Send a mail with a qr code to the user - need to be authentified and role = user",
     *     tags={"BookingManagement"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function sendQrCode(): JsonResponse
    {
        try {
            $user = Auth::user();

            Mail::to($user->email)->send(new QrCodeMail($user->id));

            return response()->json(["message" => "mail successfully sent"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while sending email',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
