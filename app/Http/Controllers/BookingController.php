<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Mail\BookingMail;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Service;
use App\Services\AttachService;
use App\Services\BookingPriceCalculationService;
use App\Services\BookingService;
use App\Services\ErrorsService;
use App\Services\SyncService;
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
    protected ErrorsService $errorsService;
    protected SyncService $syncService;
    protected AttachService $attachService;

    public function __construct(
        BookingPriceCalculationService $bookingPriceCalculationService,
        ErrorsService $errorsService,
        SyncService $syncService,
        AttachService $attachService,
    )
    {
        $this->bookingPriceCalculationService = $bookingPriceCalculationService;
        $this->errorsService = $errorsService;
        $this->syncService = $syncService;
        $this->attachService = $attachService;
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
            return $this->errorsService->modelNotFoundException('booking', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('booking', $e);
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
            return $this->errorsService->exception('booking', $e);
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
     *             required={"check_in", "check_out", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-04-10"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-04-15"),
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
    public function addBooking(BookingRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $bookingService = new BookingService();
            forEach($validatedData['rooms'] as $room){
                if (!$bookingService->checkRoomAvailability($room, $validatedData['check_in'], $validatedData['check_out'])) {
                    throw new Exception("The room ". $room ." is not available for the given date");
                }
            }

            $user = Auth::user();
            $booking = new Booking($validatedData);

            $rooms = Room::whereIn('id', $validatedData['rooms'])->get();
            $services = Service::whereIn('id', $validatedData['services'])->get();
            $price = $this->bookingPriceCalculationService->calculatePrice($validatedData['check_in'], $validatedData['check_out'], $rooms, $services);
            $booking->total_price_in_cent = $price;
            $booking->to_be_paid_in_cent = $price;
            $booking->user_id = $user->id;
            $booking->save();

//          Associe rooms et services si fournis dans le body de la requete
            $this->attachService->attachRelatedModel($booking, $validatedData['rooms']);
            $this->attachService->attachRelatedModel($booking, $validatedData['services']);

            Mail::to($user->email)->send(new BookingMail($booking->load(['services', 'rooms.category', 'user'])));

            return response()->json($booking->load(['services', 'rooms.category', 'user']), 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('booking', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('booking', $e);
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
     *             required={"check_in", "check_out", "rooms"},
     *             @OA\Property(property="check_in", type="string", format="date", example="2025-06-01"),
     *             @OA\Property(property="check_out", type="string", format="date", example="2025-06-10"),
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
    public function updateBooking(BookingRequest $request, string $id): JsonResponse
    {
        try{
            $validatedData = $request->validated();
            $booking = Booking::findOrFail($id);
//          Check si le user est bien le proprio de la résa et empeche l'update
            $this->authorize('update', $booking); // policy check

            $bookingService = new BookingService();
            forEach($validatedData['rooms'] as $room){
                if (!$bookingService->checkRoomAvailability($room, $validatedData['check_in'], $validatedData['check_out'])) {
                    throw new Exception("The room is not available for the given date");
                }
            }

            $booking->fill($validatedData);

            $rooms = Room::whereIn('id', $validatedData['rooms'])->get();
            $services = Service::whereIn('id', $validatedData['services'])->get();
            $price = $this->bookingPriceCalculationService->calculatePrice($validatedData['check_in'], $validatedData['check_out'], $rooms, $services);
            $booking->total_price_in_cent = $price;
            $booking->to_be_paid_in_cent = $price;
            $booking->save();

            $this->syncService->syncRelatedModel($booking, $validatedData['rooms']);
            $this->syncService->syncRelatedModel($booking, $validatedData['services']);

            return response()->json($booking->load(['services', 'rooms', 'user']));
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('booking', $e);
        } catch (ValidationException $e){
            return $this->errorsService->validationException('booking', $e);
        } catch (Exception $e){
            return $this->errorsService->exception('booking', $e);
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
            return $this->errorsService->modelNotFoundException('booking', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('booking', $e);
        }
    }
}
