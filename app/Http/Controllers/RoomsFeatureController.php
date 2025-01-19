<?php

namespace App\Http\Controllers;

use App\Models\RoomsFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoomsFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $features = RoomsFeature::all();
        return response()->json($features);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validation des données entrantes
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Création et sauvegarde de la nouvelle catégorie
            $roomFeature = new RoomsFeature($validatedData);
            $roomFeature->save();

            // Retourne une réponse JSON avec les données enregistrées
            return response()->json($roomFeature, 201);
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
    public function show(string $id): JsonResponse
    {
        $feature = RoomsFeature::findOrFail($id);

        if (!$feature) {
            return response()->json(['error' => 'equipement non trouvée'], 404);
        }

        return response()->json($feature);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $feature = RoomsFeature::findOrFail($id);

            if (!$feature) {
                return response()->json(['error' => 'equipement non trouvé'], 404);
            }

            $feature->update($validatedData);

            return response()->json($feature);
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
    public function destroy(string $id): JsonResponse
    {
        $feature = RoomsFeature::findOrFail($id);

        if (!$feature) {
            return response()->json(['error' => 'equipement non trouvé'], 404);
        }

        $feature->delete();

        return response()->json(['message' => 'equipement supprimé avec succès']);
    }

}
