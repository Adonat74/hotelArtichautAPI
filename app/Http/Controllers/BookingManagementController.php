<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeMail;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingManagementController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/booking-management/qr-code/user-{id}",
     *     summary="Send a mail with a qr code to the user",
     *     tags={"BookingManagement"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getQrCode(int $id): JsonResponse
    {
        try {
            $qrCodeData = "https://upload.wikimedia.org/wikipedia/commons/f/f6/Toucher_rectal.jpg";

            Mail::to('lucas.gratien@le-campus-numerique.fr')->send(new QrCodeMail($qrCodeData));

            return response()->json(["message" => "mail successfully sent"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while sending email',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
