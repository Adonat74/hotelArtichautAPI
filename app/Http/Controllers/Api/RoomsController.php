<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $rooms = Rooms::all();
        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Validation des données entrantes
            $validatedData = $request->validate([
                'number' => 'bail|required|integer',
                'description' => 'bail|required|string|max:255',
                'price_in_cents' => 'bail|required|integer',
                'fk_has_rooms_categories' => 'bail|required|integer',
            ]);

            // Création et sauvegarde de la nouvelle catégorie
            $room = new Rooms($validatedData);
            $room->save();

            // Retourne une réponse JSON avec les données enregistrées
            return response()->json($room, 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], 422);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Une erreur inattendue est survenue.',
                'details' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $room = Rooms::findOrFail($id);

        if (!$room) {
            return response()->json(['error' => 'Chambre non trouvée'], 404);
        }

        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'number' => 'bail|required|integer',
                'description' => 'bail|required|string|max:255',
                'price_in_cents' => 'bail|required|integer',
                'fk_has_rooms_categories' => 'bail|required|integer',
            ]);

            $room = Rooms::findOrFail($id);

            if (!$room) {
                return response()->json(['error' => 'chambre non trouvée'], 404);
            }

            $room->update($validatedData);

            return response()->json($room);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], 422);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Une erreur inattendue est survenue.',
                'details' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $room = Rooms::findOrFail($id);

        if (!$room) {
            return response()->json(['error' => 'chambre non trouvée'], 404);
        }

        $room->delete();

        return response()->json(['message' => 'chambre supprimée avec succès']);
    }

}
