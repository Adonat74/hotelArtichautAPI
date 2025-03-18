<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/booking/{id}",
     *     summary="Get one booking by id- need to be authentified and role = booking",
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
     *     summary="Get all user bookings - need to be authentified",
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
     *     summary="Add a booking  - need to be authentified",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *                mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"rate", "booking_content", "display_order"},
     *                  @OA\Property(
     *                      property="rate",
     *                      type="number",
     *                      description="The rating of the booking, between 1 and 5"
     *                  ),
     *                  @OA\Property(
     *                      property="booking_content",
     *                      type="string",
     *                      description="The Content_models of the booking"
     *                  ),
     *              )
     *          )
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
                'total_price_in_cents' => 'bail|required|integer',
                'to_be_paid_in_cents' => 'bail|required|integer',
                'rooms' => 'bail|required|array',
                'rooms.*' => 'bail|required|exists:rooms,id',
                'services' => 'nullable|array',
                'services.*' => 'nullable|exists:services,id',
            ]);

            $user = $request->user();

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
     *     path="/api/booking/{id}",
     *     summary="Update an existing booking- need to be authentified and role = booking",
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
     *          @OA\MediaType(
     *               mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"email", "password", "firstname", "lastname", "address", "city", "postal_code", "phone", "is_pro"},
     *                  @OA\Property(property="email", type="string", format="email", description="Booking's email address"),
     *                  @OA\Property(property="password", type="string", description="Booking's password (minimum 10 characters)"),
     *                  @OA\Property(property="firstname", type="string", maxLength=50, description="Booking's first name"),
     *                  @OA\Property(property="lastname", type="string", maxLength=50, description="Booking's last name"),
     *                  @OA\Property(property="address", type="string", maxLength=100, description="Booking's address"),
     *                  @OA\Property(property="city", type="string", maxLength=100, description="Booking's city"),
     *                  @OA\Property(property="postal_code", type="string", description="Booking's postal code (5 digits)"),
     *                  @OA\Property(property="phone", type="string", description="Booking's phone number (10 digits)"),
     *                  @OA\Property(property="is_pro", type="boolean", description="Indicates te booking status of pro or not"),
     *              )
     *          )
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
                'total_price_in_cents' => 'bail|required|integer',
                'to_be_paid_in_cents' => 'bail|required|integer',
                'rooms' => 'bail|required|array',
                'rooms.*' => 'bail|required|exists:rooms,id',
                'services' => 'nullable|array',
                'services.*' => 'nullable|exists:services,id',
            ]);
            $booking = Booking::findOrFail($id);
//          Check si le user est bien le proprio de la résa et empeche l'update
            $this->authorize('update', $booking); // policy check

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
     *     summary="Delete a booking by id- need to be authentified and role = booking",
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
