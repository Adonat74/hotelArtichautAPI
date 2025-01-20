<?php

    namespace App\Http\Controllers;

    use App\Models\RoomsFeature;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
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
                    'roomsCategories' => 'array|exists:rooms_categories,id',  // Validation des catégories
                    'roomsCategories.*' => 'exists:rooms_categories,id',
                ]);

                // Création et sauvegarde de la nouvelle catégorie
                $roomFeature = new RoomsFeature($validatedData);
                $roomFeature->save();

                // Attachez les catégories à l'équipement
                if (!empty($validatedData['roomsCategories'])) {
                    $roomFeature->roomsCategories()->attach($validatedData['roomsCategories']);
                }

                // Retourne une réponse JSON avec les données enregistrées
                return response()->json($roomFeature->load('roomsCategories'), 201);
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
        public function showById(string $id): JsonResponse
        {
            // Charger le feature avec ses catégories associées
            $feature = RoomsFeature::with('roomsCategories:id,name') // Charger uniquement ID et nom des catégories
            ->findOrFail($id, ['id', 'name', 'description']); // Charger les colonnes pertinentes du feature

            // Structurer la réponse pour un retour clair
            $response = [
                'id' => $feature->id,
                'name' => $feature->name,
                'description' => $feature->description,
                'Room categories' => $feature->roomsCategories
            ];

            return response()->json($response);
        }

        public function show(Request $request): JsonResponse{
            // Charger le feature avec ses catégories associées
            /* $feature = RoomsFeature::with('roomsCategories:id,name')
                 ->findOrFail($request->id);
             // Structurer la réponse pour un retour clair
             $response = [
                 'id' => $feature->id,
                 'name' => $feature->name,
                 'description' => $feature->description,
                 'Room categories' => $feature->roomsCategories,
             ];

             return response()->json($response);*/

            return response()->json(RoomsFeature::with('roomsCategories')->get());
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
                    'roomsCategories' => 'array|exists:rooms_categories,id',  // Validation des catégories
                    'roomsCategories.*' => 'exists:rooms_categories,id',
                ]);

                $feature = RoomsFeature::findOrFail($id);

                $feature->update($validatedData);

                if (isset($validatedData['roomsCategories'])) {
                    $feature->features()->sync($validatedData['roomsCategories']);
                }

                return response()->json($feature->load('roomsCategories'));
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

            try{

                $feature = RoomsFeature::findOrFail($id);
                $feature->roomsCategories()->detach();
                $feature->delete();
                return response()->json(['message' => 'feature supprimée avec succès'], 204);
            } catch (ModelNotFoundException $exception) {
                return response()->json(['error' => 'Catégorie non trouvée'], 404);
            } catch (\Exception $exception) {
                return response()->json([
                    'error' => 'Une erreur inattendue est survenue.',
                    'details' => $exception->getMessage(),
                ],500);
            }
        }

    }
