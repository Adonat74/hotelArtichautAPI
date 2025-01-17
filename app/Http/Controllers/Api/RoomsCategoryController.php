<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\RoomsCategory;
    use Illuminate\Http\Request;
    use Illuminate\Validation\ValidationException;

    class RoomsCategoryController extends Controller
    {
        /**
         * Liste toutes les catégories de chambres.
         */
        public function index(): \Illuminate\Http\JsonResponse
        {
            $categories = RoomsCategory::all();
            return response()->json($categories);
        }

        /**
         * Crée une nouvelle catégorie de chambre.
         */
        public function store(Request $request): \Illuminate\Http\JsonResponse
        {
            try {
                // Validation des données entrantes
                $validatedData = $request->validate([
                    'description' => 'bail|required|string|max:255',
                    'price_in_cents' => 'bail|required|integer',
                    'bed_size' => 'bail|required|integer',
                ]);

                // Création et sauvegarde de la nouvelle catégorie
                $roomCategory = new RoomsCategory($validatedData);
                $roomCategory->save();

                // Retourne une réponse JSON avec les données enregistrées
                return response()->json($roomCategory, 201);
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
         * Affiche une catégorie spécifique par son ID.
         */
        public function show($id): \Illuminate\Http\JsonResponse
        {
            $category = RoomsCategory::findOrFail($id);

            if (!$category) {
                return response()->json(['error' => 'Catégorie non trouvée'], 404);
            }

            return response()->json($category);
        }

        /**
         * Met à jour une catégorie de chambre existante.
         */
        public function update(Request $request, $id): \Illuminate\Http\JsonResponse
        {
            try {
                $validatedData = $request->validate([
                    'description' => 'bail|required|string|max:255',
                    'price_in_cents' => 'bail|required|integer',
                    'bed_size' => 'bail|required|integer',
                ]);

                $category = RoomsCategory::findOrFail($id);

                if (!$category) {
                    return response()->json(['error' => 'Catégorie non trouvée'], 404);
                }

                $category->update($validatedData);

                return response()->json($category);
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
         * Supprime une catégorie de chambre existante.
         */
        public function destroy($id): \Illuminate\Http\JsonResponse
        {
            $category = RoomsCategory::findOrFail($id);

            if (!$category) {
                return response()->json(['error' => 'Catégorie non trouvée'], 404);
            }

            $category->delete();

            return response()->json(['message' => 'Catégorie supprimée avec succès']);
        }

        public function listFeatures($id): \Illuminate\Http\JsonResponse
        {
            $category = RoomsCategory::findOrFail($id);
            $features = $category->features;
            return response()->json($features);
        }

        /**
         * Associe une fonctionnalité à une catégorie.
         */
        public function attachFeature(Request $request, $id): \Illuminate\Http\JsonResponse
        {
            $request->validate(['feature_id' => 'required|exists:rooms_features,id']);

            $category = RoomsCategory::findOrFail($id);
            $category->features()->attach($request->feature_id);

            return response()->json(['message' => 'Feature attached successfully']);
        }

        /**
         * Dissocie une fonctionnalité d'une catégorie.
         */
        public function detachFeature($id, $featureId): \Illuminate\Http\JsonResponse
        {
            $category = RoomsCategory::findOrFail($id);
            $category->features()->detach($featureId);

            return response()->json(['message' => 'Feature detached successfully']);
        }

        public function getFeatures($roomCategoryId): \Illuminate\Http\JsonResponse
        {
            $roomCategory = RoomsCategory::with('features')->findOrFail($roomCategoryId);

            return response()->json([
                'room_category' => $roomCategory->name,
                'features' => $roomCategory->features,
            ]);
        }

    }
