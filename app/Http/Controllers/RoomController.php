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
     * Display the specified resource.
     */
    public function getSingleRoom(int $id): JsonResponse
    {
        try {
            $room = Room::with(['images', 'category'])->findOrFail($id);
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
     * Display a listing of the resource.
     */
    public function getAllRooms(): JsonResponse
    {
        try {
            $rooms = Room::with(['images', 'category'])->get();
            return response()->json($rooms);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the services',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addRoom(Request $request): JsonResponse
    {
        try {
            // Validation des données entrantes
            $validatedData = $request->validate([
                'number' => 'bail|required|integer',
                'name' => 'bail|required|string|max:255',
                'description' => 'bail|required|string|max:255',
                'rooms_category_id' => 'bail|required|integer',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);

            // Création et sauvegarde de la nouvelle catégorie
            $room = new Room([
                'number' => $validatedData['number'],
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'rooms_category_id' => $validatedData['rooms_category_id'],
            ]);
            $room->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    //enregistre les images dans le dossier storage/app/public/images et l'url pour y accéder dans la table image
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => $imagePath,
                        'room_id' => $room->id,
                    ]);
                    $image->save();
                }
            }
            // Retourne une réponse JSON avec les données enregistrées
            return response()->json([
                'addedRoom' => $room->load(['images', 'category']),
            ], 201);
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
     * Update the specified resource in storage.
     */
    public function updateRoom(Request $request, string $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'number' => 'bail|required|integer',
                'name' => 'bail|required|string|max:255',
                'description' => 'bail|required|string|max:255',
                'rooms_category_id' => 'bail|required|integer',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);
            $room = Room::findOrFail($id);
            $room->update([
                'number' => $validatedData['number'],
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'rooms_category_id' => $validatedData['rooms_category_id'],
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
                        'url' => $imagePath,
                        'room_id' => $room->id,
                    ]);
                    $image->save();
                }
            }


            return response()->json([
                'updatedRoom' => $room->load(['images', 'category']),
            ]);
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
     * Remove the specified resource from storage.
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
