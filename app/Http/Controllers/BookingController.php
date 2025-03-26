<?php

namespace App\Http\Controllers;

use App\Mail\BookingMail;
use App\Mail\QrCodeMail;
use App\Models\Booking;
use App\Services\BookingPriceCalculationService;
use App\Services\BookingService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    protected BookingPriceCalculationService $bookingPriceCalculationService;

    public function __construct(BookingPriceCalculationService $bookingPriceCalculationService)
    {
        $this->bookingPriceCalculationService = $bookingPriceCalculationService;
    }


    /**
     * @OA\Get(
     *     path="/api/booking/{id}",
     *     summary="Get one booking by ID (requires authentication, role = user)",
     *     tags={"Bookings"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the booking",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Booking not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getSingleUserBooking(int $id): JsonResponse
    {
        try {
            $booking = Booking::with(['services', 'rooms', 'user'])->findOrFail($id);

            $this->authorize('view', $booking); // policy check

            return response()->json($booking);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'booking not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the booking',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/booking/user",
     *     summary="Get all user bookings - need to be authentified and role = user",
     *     tags={"Bookings"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllUserBookings(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $bookings = Booking::with(['services', 'rooms', 'user'])->where('user_id', $user->id)->get();

            return response()->json($bookings);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the bookings',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/booking",
     *     summary="Add a booking  - need to be authentified and role = user",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"check_in", "check_out", "total_price_in_cents", "to_be_paid_in_cents", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-04-10"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-04-15"),
     *             @OA\Property(property="total_price_in_cents", type="integer", example=15000),
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
    public function addBooking(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'check_in' => 'bail|required|date|after_or_equal:now',
                'check_out' => 'bail|required|date|after:check_in',
                'total_price_in_cents' => 'bail|required|integer',
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

            $user = Auth::user();
            $booking = new Booking($validatedData);

            $booking->user_id = $user->id;
            $booking->save();

//            Associe rooms et services si fournis dans le body de la requete
            if (isset($validatedData['rooms'])) {
                $booking->rooms()->attach($validatedData['rooms']);
            }
            if (isset($validatedData['services'])) {
                $booking->services()->attach($validatedData['services']);
            }

            $booking->total_price_in_cents = $this->bookingPriceCalculationService->calculatePrice($booking);
            $booking->save();

//            Mail::to($user->email)->send(new BookingMail($booking->load([''])));

            return response()->json($booking->load(['services', 'rooms.category', 'user']), 201);
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

    /**
     * @OA\Post(
     *     path="/api/booking/{id}",
     *     summary="Update an existing booking- need to be authentified and role = user",
     *     tags={"Bookings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the booking",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"check_in", "check_out", "total_price_in_cents", "to_be_paid_in_cents", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-06-01"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-06-10"),
     *             @OA\Property(property="total_price_in_cents", type="integer", example=20000),
     *             @OA\Property(property="to_be_paid_in_cents", type="integer", example=7000),
     *             @OA\Property(property="number_of_persons", type="integer", example=2),
     *             @OA\Property(property="rooms", type="array", @OA\Items(type="integer"), example={4,5}),
     *             @OA\Property(property="services", type="array", @OA\Items(type="integer"), example={7,8})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Booking successfully updated"),
     *     @OA\Response(response=404, description="Booking not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateBooking(Request $request, string $id): JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'check_in' => 'bail|required|date|after_or_equal:now',
                'check_out' => 'bail|required|date|after:check_in',
                'total_price_in_cents' => 'bail|required|integer',
                'to_be_paid_in_cents' => 'bail|required|integer',
                'number_of_persons' => 'bail|required|integer',
                'rooms' => 'bail|required|array',
                'rooms.*' => 'bail|required|exists:rooms,id',
                'services' => 'nullable|array',
                'services.*' => 'nullable|exists:services,id',
            ]);
            $booking = Booking::findOrFail($id);
//          Check si le user est bien le proprio de la résa et empeche l'update
            $this->authorize('update', $booking); // policy check

            $bookingService = new BookingService();
            forEach($validatedData['rooms'] as $room){
                if (!$bookingService->checkRoomAvailability($room, $validatedData['check_in'], $validatedData['check_out'])) {
                    throw new Exception("The room is not available for the given date");
                }
            }

            $booking->update($validatedData);

            if (isset($validatedData['rooms'])) {
                $booking->rooms()->sync($validatedData['rooms']);
            }
            if (isset($validatedData['services'])) {
                $booking->services()->sync($validatedData['services']);
            }


            return response()->json($booking->load(['services', 'rooms', 'user']));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Booking not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e){
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e){
            return response()->json([
                'error' => 'An error occurred while updating the Booking',
                'details'=>    $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/booking/{id}",
     *     summary="Delete a booking by id- need to be authentified and role = user",
     *     tags={"Bookings"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the booking",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Booking not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteBooking(string $id): JsonResponse
    {
        try {
            $booking = Booking::findOrFail($id);
//          Check si le user est bien le proprio de la résa et empeche le delete

            $this->authorize('delete', $booking); // policy check

            $booking->delete();

            return response()->json(['message' => 'booking deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Booking not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the booking',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
