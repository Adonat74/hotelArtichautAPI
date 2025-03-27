<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeMail;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Service;
use App\Services\BookingPriceCalculationService;
use App\Services\BookingService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingManagementController extends Controller
{

    protected BookingPriceCalculationService $bookingPriceCalculationService;

    public function __construct(BookingPriceCalculationService $bookingPriceCalculationService)
    {
        $this->bookingPriceCalculationService = $bookingPriceCalculationService;
    }


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

            Mail::to($user->email)->send(new QrCodeMail($user));

            return response()->json(["message" => "mail successfully sent"]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while sending email',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/booking-management/total-price",
     *     summary="Get the total price of a booking",
     *     tags={"BookingManagement"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"check_in", "check_out", "total_price_in_cents", "to_be_paid_in_cents", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-04-10"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-04-15"),
     *             @OA\Property(property="to_be_paid_in_cents", type="integer", example=5000),
     *             @OA\Property(property="number_of_persons", type="integer", example=2),
     *             @OA\Property(property="rooms", type="array", @OA\Items(type="integer"), example={1,2,3}),
     *             @OA\Property(property="services", type="array", @OA\Items(type="integer"), example={5,6})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getTotalPrice(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'check_in' => 'bail|required|date|after_or_equal:now',
                'check_out' => 'bail|required|date|after:check_in',
                'to_be_paid_in_cents' => 'bail|required|integer',
                'number_of_persons' => 'bail|required|integer',
                'rooms' => 'bail|required|array',
                'rooms.*' => 'bail|required|exists:rooms,id',
                'services' => 'nullable|array',
                'services.*' => 'nullable|exists:services,id',
            ]);

            $bookingService = new BookingService();
            forEach($validatedData['rooms'] as $room){
                if (!$bookingService->checkRoomAvailability($room, $validatedData['check_in'], $validatedData['check_out'])) {
                    throw new Exception("The room ". $room ." is not available for the given date");
                }
            }

            $rooms = Room::whereIn('id', $validatedData['rooms'])->get();
            $services = Service::whereIn('id', $validatedData['services'])->get();
            $totalPrice = $this->bookingPriceCalculationService->calculatePrice($validatedData['check_in'], $validatedData['check_out'], $rooms, $services);


            return response()->json(['total_price_in_cents' => $totalPrice], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the booking',
                'message'=>    $e->getMessage(),
            ], 500);
        }
    }
}
