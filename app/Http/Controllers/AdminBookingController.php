<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminBookingController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/admin/booking/{id}",
     *     summary="Get one booking by ID (requires authentication, role = employee)",
     *     tags={"AdminBookings"},
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
    public function getSingleBooking(int $id): JsonResponse
    {
        try {
            $booking = Booking::with(['services', 'rooms', 'user'])->findOrFail($id);

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
     *     path="/api/admin/booking",
     *     summary="Get all bookings - need to be authentified and role = employee",
     *     tags={"AdminBookings"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllBookings(): JsonResponse
    {
        try {
            $bookings = Booking::with(['services', 'rooms', 'user'])
                ->get();

            return response()->json($bookings);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the bookings',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/admin/booking/user-{id}",
     *     summary="Get all user bookings - need to be authentified and role = employee",
     *     tags={"AdminBookings"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllUserBookings(int $id): JsonResponse
    {
        try {
            $bookings = Booking::with(['services', 'rooms', 'user'])
                ->where('user_id', $id)
                ->get();

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
     *     path="/api/admin/booking",
     *     summary="Add a booking - need to be authentified and role = manager",
     *     tags={"AdminBookings"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"check_in", "check_out", "total_price_in_cent", "to_be_paid_in_cent", "user_id", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-04-10"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-04-15"),
     *             @OA\Property(property="total_price_in_cent", type="integer", example=15000),
     *             @OA\Property(property="to_be_paid_in_cent", type="integer", example=5000),
     *             @OA\Property(property="user_id", type="integer", example=1),
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
                'check_in' => 'bail|required|date|after:today',
                'check_out' => 'bail|required|date|after:check_in',
                'total_price_in_cent' => 'bail|required|integer',
                'to_be_paid_in_cent' => 'bail|required|integer',
                'user_id' => 'bail|required|exists:users,id',
                'rooms' => 'bail|required|array',
                'rooms.*' => 'bail|required|exists:rooms,id',
                'services' => 'nullable|array',
                'services.*' => 'nullable|exists:services,id',
            ]);

            $bookingService = new BookingService();
            forEach($validatedData['rooms'] as $room){
                if (!$bookingService->checkRoomAvailability($room, $validatedData['check_in'], $validatedData['check_out'])) {
                    throw new Exception("The room is not available for the given date");
                }
            }

            $booking = new Booking($validatedData);
            $booking->save();

//            Associe rooms et services si fournis dans le body de la requete
            if (isset($validatedData['rooms'])) {
                $booking->rooms()->attach($validatedData['rooms']);
            }
            if (isset($validatedData['services'])) {
                $booking->services()->attach($validatedData['services']);
            }

            return response()->json($booking->load(['services', 'rooms', 'user']), 201);
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
     *     path="/api/admin/booking/{id}",
     *     summary="Update an existing booking- need to be authentified and role = manager",
     *     tags={"AdminBookings"},
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
     *             required={"check_in", "check_out", "total_price_in_cent", "to_be_paid_in_cent", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-06-01"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-06-10"),
     *             @OA\Property(property="total_price_in_cent", type="integer", example=20000),
     *             @OA\Property(property="to_be_paid_in_cent", type="integer", example=7000),
     *             @OA\Property(property="user_id", type="integer", example=1),
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
                'check_in' => 'bail|required|date|after:today',
                'check_out' => 'bail|required|date|after:check_in',
                'total_price_in_cent' => 'bail|required|integer',
                'to_be_paid_in_cent' => 'bail|required|integer',
                'user_id' => 'bail|required|exists:users,id',
                'rooms' => 'bail|required|array',
                'rooms.*' => 'bail|required|exists:rooms,id',
                'services' => 'nullable|array',
                'services.*' => 'nullable|exists:services,id',
            ]);
            $booking = Booking::findOrFail($id);
//          Check si le user est bien le proprio de la résa et empeche l'update

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
     *     path="/api/admin/booking/{id}",
     *     summary="Delete a booking by id- need to be authentified and role = manager",
     *     tags={"AdminBookings"},
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
