<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Room;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class RoomController extends Controller
{

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
            $room = Room::with(['images', 'category', 'language'])->findOrFail($id);
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
    public function getAllRooms(int $lang): JsonResponse
    {
        try {
            $rooms = Room::where('language_id', $lang)->with(['images', 'category', 'language'])->get();
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
     *                  required={"number", "name", "description", "rooms_category_id"},
     *                  @OA\Property(property="number", type="integer", description="Room number"),
     *                  @OA\Property(property="name", type="string", description="Room name"),
     *                  @OA\Property(property="description", type="string", description="Room description"),
     *                  @OA\Property(property="rooms_category_id", type="integer", description="Room category ID"),
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
                'number' => 'bail|required|integer',
                'name' => 'bail|required|string|max:255',
                'description' => 'bail|required|string|max:255',
                'rooms_category_id' => 'bail|required|integer|exists:rooms_categories,id',
                'language_id' => 'bail|required|numeric',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);

            // Création et sauvegarde de la nouvelle catégorie
            $room = new Room([
                'number' => $validatedData['number'],
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'rooms_category_id' => $validatedData['rooms_category_id'],
                'language_id' => $validatedData['language_id'],
            ]);
            $room->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    //enregistre les images dans le dossier storage/app/public/images et l'url pour y accéder dans la table image
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => url('storage/' . $imagePath),
                        'room_id' => $room->id,
                    ]);
                    $image->save();
                }
            }
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
     *                  required={"number", "name", "description", "rooms_category_id", "images[]"},
     *                  @OA\Property(property="number", type="integer", description="Room number"),
     *                  @OA\Property(property="name", type="string", description="Room name"),
     *                  @OA\Property(property="description", type="string", description="Room description"),
     *                  @OA\Property(property="rooms_category_id", type="integer", description="Room category ID"),
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
                'number' => 'bail|required|integer',
                'name' => 'bail|required|string|max:255',
                'description' => 'bail|required|string|max:255',
                'rooms_category_id' => 'bail|required|integer|exists:rooms_categories,id',
                'language_id' => 'bail|required|numeric',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);
            $room = Room::findOrFail($id);
            $room->update([
                'number' => $validatedData['number'],
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'rooms_category_id' => $validatedData['rooms_category_id'],
                'language_id' => $validatedData['language_id'],
            ]);

            if ($request->hasFile('images')) {
                $existingImages = $room->images()->get();

                //supprime les images du strage et l'url de la table images
                if ($existingImages) {
                    foreach ($existingImages as $existingImage) {
                        Storage::disk('public')->delete($existingImage->url);
                        $existingImage->delete();
                    }
                }

                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => url('storage/' . $imagePath),
                        'room_id' => $room->id,
                    ]);
                    $image->save();
                }
            }


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
            $existingImages = $room->images()->get();

            if ($existingImages) {
                foreach ($existingImages as $existingImage) {
                    Storage::disk('public')->delete($existingImage->url);
                    $existingImage->delete();
                }
            }
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
