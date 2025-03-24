<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Room;
use App\Services\BookingService;
use App\Services\ImagesManagementService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class RoomController extends Controller
{
    protected ImagesManagementService $imagesManagementService;

    public function __construct(ImagesManagementService $imagesManagementService)
    {
        $this->imagesManagementService = $imagesManagementService;
    }


    /**
     * @OA\Get(
     *     path="/api/room/{id}",
     *     summary="Get one room by id",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the room",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Room not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getSingleRoom(int $id): JsonResponse
    {
        try {

            $room = Room::with(['images', 'category.features', 'language'])->findOrFail($id);
            return response()->json($room);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Room not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/room/lang-{lang}",
     *     summary="Get all roomsby language selected",
     *     tags={"Rooms"},
     *       @OA\Parameter(
     *            name="lang",
     *            in="path",
     *            description="The lang desired",
     *            required=true,
     *            @OA\Schema(type="integer")
     *       ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllRoomsByLang(int $lang): JsonResponse
    {
        try {
//          Query qui sert à récupérer uniquement les réservations qui sont en cours et avec ça le user associé.
            $now = Carbon::now();
            $rooms = Room::where('language_id', $lang)
                ->with(['images', 'category', 'language', 'bookings' => function($query) use ($now) { // on peut faire des query dans le with pour filtrer par exemple
                    $query->where('check_in', '<', $now)
                        ->where('check_out', '>=', $now);
                } ,'bookings.user'])
                ->get();


            return response()->json($rooms);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the services',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/room/lang-{lang}/available",
     *     summary="Get all roomsby language selected and filter by date selected ?check_in=2025-03-21&check_out=2025-04-03&category=1 for example(if no category selected return all rooms)",
     *     tags={"Rooms"},
     *       @OA\Parameter(
     *            name="lang",
     *            in="path",
     *            description="The lang desired",
     *            required=true,
     *            @OA\Schema(type="integer")
     *       ),
     *      @OA\Parameter(
     *           name="check_in",
     *           in="query",
     *           description="Check-in date (YYYY-MM-DD)",
     *           required=true,
     *           @OA\Schema(type="string", format="date", example="2025-03-21")
     *      ),
     *      @OA\Parameter(
     *           name="check_out",
     *           in="query",
     *           description="Check-out date (YYYY-MM-DD)",
     *           required=true,
     *           @OA\Schema(type="string", format="date", example="2025-04-03")
     *      ),
     *      @OA\Parameter(
     *          name="category",
     *          in="query",
     *          description="Room category ID (optional)",
     *          required=false,
     *          @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request parameters"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllRoomsAvailableByLang(int $lang, Request $request): JsonResponse
    {
        try {
            if($request->has('category')) {
                $rooms = Room::where('language_id', $lang)
                    ->where('rooms_category_id', $request->query('category'))
                    ->with(['images', 'category', 'language'])
                    ->get();
            } else {
                $rooms = Room::where('language_id', $lang)
                    ->orderBy('rooms_category_id')
                    ->with(['images', 'category', 'language'])
                    ->get();
            }

            $bookingService = new BookingService();
            forEach($rooms as $key => $room){
                if (!$bookingService->checkRoomAvailability($room->id,$request->query('check_in'), $request->query('check_out'))) {
                    unset($rooms[$key]);
                }
            }

            $rooms = $rooms->values(); // Reindex the collection
            return response()->json($rooms);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the services',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/room",
     *     summary="Get all rooms",
     *     tags={"Rooms"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllRooms(): JsonResponse
    {
        try {
            $rooms = Room::with(['images', 'category', 'language'])->get();
            return response()->json($rooms);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the services',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/room",
     *     summary="Add a new room",
     *     tags={"Rooms"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name", "number", "room_name", "description", "rooms_category_id", "display_order", "language_id"},
     *                    @OA\Property(
     *                        property="name",
     *                        type="string",
     *                        description="The name to group with other languages"
     *                    ),
     *                  @OA\Property(property="number", type="integer", description="Room number"),
     *                  @OA\Property(property="room_name", type="string", description="Room name"),
     *                  @OA\Property(property="description", type="string", description="Room description"),
     *                  @OA\Property(property="rooms_category_id", type="integer", description="Room category ID"),
     *                   @OA\Property(
     *                       property="display_order",
     *                       type="integer",
     *                       description="The desired disaly order the items should be"
     *                   ),
     *                  @OA\Property(
     *                      property="language_id",
     *                      type="integer",
     *                      description="The ID of the language"
     *                  ),
     *                  @OA\Property(property="images[]", type="array", @OA\Items(type="string", format="binary"))
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Room created successfully"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addRoom(Request $request): JsonResponse
    {
        try {
            // Validation des données entrantes
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:50',
                'number' => 'bail|required|integer',
                'room_name' => 'bail|required|string|max:255',
                'description' => 'bail|required|string|max:255',
                'rooms_category_id' => 'bail|required|integer|exists:rooms_categories,id',
                'display_order' => 'bail|required|integer',
                'language_id' => 'bail|required|numeric|exists:languages,id',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',// vérifie que les éléments sont des images
            ]);

            // Création et sauvegarde de la nouvelle catégorie
            $room = new Room([
                'name' => $validatedData['name'],
                'number' => $validatedData['number'],
                'room_name' => $validatedData['room_name'],
                'description' => $validatedData['description'],
                'rooms_category_id' => $validatedData['rooms_category_id'],
                'display_order' => $validatedData['display_order'],
                'language_id' => $validatedData['language_id'],
            ]);
            $room->save();

            $this->imagesManagementService->addImages($request, $room, 'room_id');


            // Retourne une réponse JSON avec les données enregistrées
            return response()->json($room->load(['images', 'category', 'language']), 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the room',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/room/{id}",
     *     summary="Update an existing room",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Room ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name", "number", "room_name", "description", "rooms_category_id", "display_order", "language_id"},
     *                   @OA\Property(
     *                       property="name",
     *                       type="string",
     *                       description="The name to group with other languages"
     *                   ),
     *                  @OA\Property(property="number", type="integer", description="Room number"),
     *                  @OA\Property(property="room_name", type="string", description="Room room_name"),
     *                  @OA\Property(property="description", type="string", description="Room description"),
     *                  @OA\Property(property="rooms_category_id", type="integer", description="Room category ID"),
     *                   @OA\Property(
     *                       property="display_order",
     *                       type="integer",
     *                       description="The desired disaly order the items should be"
     *                   ),
     *                  @OA\Property(
     *                      property="language_id",
     *                      type="integer",
     *                      description="The ID of the language"
     *                  ),
     *                  @OA\Property(property="images[]", type="array", @OA\Items(type="string", format="binary"))
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="Room updated successfully"),
     *     @OA\Response(response=404, description="Room not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateRoom(Request $request, string $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:50',
                'number' => 'bail|required|integer',
                'room_name' => 'bail|required|string|max:255',
                'description' => 'bail|required|string|max:255',
                'rooms_category_id' => 'bail|required|integer|exists:rooms_categories,id',
                'display_order' => 'bail|required|integer',
                'language_id' => 'bail|required|numeric|exists:languages,id',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',// vérifie que les éléments sont des images
            ]);
            $room = Room::findOrFail($id);
            $room->update([
                'name' => $validatedData['name'],
                'number' => $validatedData['number'],
                'room_name' => $validatedData['room_name'],
                'description' => $validatedData['description'],
                'rooms_category_id' => $validatedData['rooms_category_id'],
                'display_order' => $validatedData['display_order'],
                'language_id' => $validatedData['language_id'],
            ]);


            $this->imagesManagementService->updateImages($request, $room, 'room_id');


            return response()->json($room->load(['images', 'category', 'language']));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Room not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the Room',
                'details' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * @OA\Delete(
     *     path="/api/room/{id}",
     *     summary="Delete a room by ID",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the room to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Room deleted successfully"),
     *     @OA\Response(response=404, description="Room not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteRoom(string $id): JsonResponse
    {
        try {
            $room = Room::findOrFail($id);

            $this->imagesManagementService->deleteImages($room);

            $room->delete();

            return response()->json(['message' => 'room deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Room not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the room',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
