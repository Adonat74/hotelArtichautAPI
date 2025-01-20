<?php

    namespace App\Http\Controllers;

    use App\Models\RoomsCategory;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Validation\ValidationException;

    class RoomsCategoryController extends Controller
    {
        /**
         * Liste toutes les catégories de chambres.
         */
        public function index(): JsonResponse
        {
            $categories = RoomsCategory::all();
            return response()->json($categories);
        }

        /**
         * Crée une nouvelle catégorie de chambre.
         */
        public function store(Request $request): JsonResponse
        {
            try {
                // Validation des données entrantes
                $validatedData = $request->validate([
                    'description' => 'bail|required|string|max:255',
                    'price_in_cent' => 'bail|required|integer',
                    'bed_size' => 'bail|required|integer',
                    'features' => 'array', // Accepter un tableau de features
                    'features.*' => 'exists:rooms_features,id', // Valider que chaque feature existe
                ]);

                // Création et sauvegarde de la nouvelle catégorie
                $roomCategory = new RoomsCategory($validatedData);
                $roomCategory->save();

                // Si des features sont fournies, les associer à la catégorie
                if (!empty($validatedData['features'])) {
                    $roomCategory->features()->sync($validatedData['features']);
                }

                // Retourne une réponse JSON avec les données enregistrées
                return response()->json($roomCategory, 201);
            } catch (ValidationException $exception) {
                return response()->json([
                    'error' => $exception->getMessage(),
                    'errors' => $exception->errors(),
                ], 422);
            } catch (Exception $exception) {
                return response()->json([
                    'error' => 'Une erreur inattendue est survenue.',
                    'details' => $exception->getMessage(),
                ], 500);
            }
        }

        /**
         * Affiche une catégorie spécifique par son ID.
         */
        public function show($id): JsonResponse
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
        public function update(Request $request, $id): JsonResponse
        {
            try {
                // Validation des données entrantes
                $validatedData = $request->validate([
                    'description' => 'bail|required|string|max:255',
                    'price_in_cent' => 'bail|required|integer',
                    'bed_size' => 'bail|required|integer',
                    'features' => 'array', // Accepter un tableau de features
                    'features.*' => 'exists:rooms_features,id', // Valider que chaque feature existe
                ]);

                // Récupérer la catégorie
                $category = RoomsCategory::findOrFail($id);

                // Mettre à jour les champs de la catégorie
                $category->update($validatedData);

                // Si des features sont fournies, les associer à la catégorie
                if (isset($validatedData['features'])) {
                    $category->features()->sync($validatedData['features']);
                }

                // Charger les relations pour la réponse
                return response()->json($category->load('features'));
            } catch (ValidationException $exception) {
                return response()->json([
                    'error' => $exception->getMessage(),
                    'errors' => $exception->errors(),
                ], 422);
            } catch (Exception $exception) {
                return response()->json([
                    'error' => 'Une erreur inattendue est survenue.',
                    'details' => $exception->getMessage(),
                ], 500);
            }
        }


        /**
         * Supprime une catégorie de chambre existante.
         */
        public function destroy($id): JsonResponse
        {
            try {
                // Récupérer la catégorie avec ses relations
                $category = RoomsCategory::findOrFail($id);

                // Supprimer les relations avec les features
                $category->features()->detach();

                // Supprimer la catégorie
                $category->delete();

                return response()->json(['message' => 'Catégorie supprimée avec succès'], 204);
            } catch (ModelNotFoundException $exception) {
                return response()->json(['error' => 'Catégorie non trouvée'], 404);
            } catch (\Exception $exception) {
                return response()->json([
                    'error' => 'Une erreur inattendue est survenue.',
                    'details' => $exception->getMessage(),
                ], 500);
            }
        }


        public function listFeatures($id): JsonResponse
        {
            $category = RoomsCategory::with('roomsFeatures')->findOrFail($id);
            $features = $category->features;
            return response()->json($features);
        }

        /**
         * Associe une fonctionnalité à une catégorie.
         */
        public function attachFeature(Request $request, $id): JsonResponse
        {
            $request->validate(['feature_id' => 'required|exists:rooms_features,id']);

            $category = RoomsCategory::findOrFail($id);
            $category->features()->attach($request->feature_id);

            return response()->json(['message' => 'Feature attached successfully']);
        }

        /**
         * Dissocie une fonctionnalité d'une catégorie.
         */
        public function detachFeature($id, $featureId): JsonResponse
        {
            $category = RoomsCategory::findOrFail($id);
            $category->features()->detach($featureId);

            return response()->json(['message' => 'Feature detached successfully']);
        }

        public function getFeatures($roomCategoryId): JsonResponse
        {
            $roomCategory = RoomsCategory::with('features')->findOrFail($roomCategoryId);

            return response()->json([
                'room_category' => $roomCategory->name,
                'features' => $roomCategory->features,
            ]);
        }

    }
