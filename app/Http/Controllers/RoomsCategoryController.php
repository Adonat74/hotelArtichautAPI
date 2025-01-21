<?php

    namespace App\Http\Controllers;

    use App\Models\Image;
    use App\Models\RoomsCategory;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Validation\ValidationException;

    class RoomsCategoryController extends Controller
    {


        /**
         * Affiche une catégorie spécifique par son ID.
         */
        public function getSingleCategory(int $id): JsonResponse
        {
            try {
                $category = RoomsCategory::with(['features', 'rooms', 'images'])->findOrFail($id);
                return response()->json($category);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => 'Category not found',
                    'message' => $e->getMessage(),
                ], 404);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while fetching the category',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }




        /**
         * Liste toutes les catégories de chambres.
         */
        public function getAllCategories(): JsonResponse
        {
            try {
                $categories = RoomsCategory::with(['features', 'rooms', 'images'])->get();
                return response()->json($categories);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while fetching the categories',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }



        /**
         * Crée une nouvelle catégorie de chambre.
         */
        public function addCategory(Request $request): JsonResponse
        {
            try {
                $validatedData = $request->validate([
                    'name' => 'bail|required|string|max:255',
                    'description' => 'bail|required|string|max:1000',
                    'price_in_cent' => 'bail|required|integer',
                    'bed_size' => 'bail|required|integer',
                    'rooms_features' => 'nullable|array', // Accepter un tableau de features
                    'rooms_features.*' => 'nullable|exists:rooms_features,id', // Valider que chaque feature exist
                    'images' => 'nullable|array',
                    'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                ]);
                $roomCategory = new RoomsCategory([
                    'name' => $validatedData['name'],
                    'description' => $validatedData['description'],
                    'price_in_cent' => $validatedData['price_in_cent'],
                    'bed_size' => $validatedData['bed_size'],
                ]);
                $roomCategory->save();

                // Si des features sont fournies, les associer à la catégorie
                if (isset($validatedData['rooms_features'])) {
                    $roomCategory->features()->attach($validatedData['rooms_features']);
                }

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $imagePath = $image->store('images', 'public');
                        $image = new Image([
                            'url' => url('storage/' . $imagePath),
                            'rooms_category_id' => $roomCategory->id,
                        ]);
                        $image->save();
                    }
                }
                // Retourne une réponse JSON avec les données enregistrées
                return response()->json($roomCategory->load(['features', 'images']), 201);
            } catch (ValidationException $e) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while adding the category',
                    'details' => $e->getMessage(),
                ], 500);
            }
        }



        /**
         * Met à jour une catégorie de chambre existante.
         */
        public function updateCategory(Request $request, $id): JsonResponse
        {
            try {
                $validatedData = $request->validate([
                    'name' => 'bail|required|string|max:255',
                    'description' => 'bail|required|string|max:1000',
                    'price_in_cent' => 'bail|required|integer',
                    'bed_size' => 'bail|required|integer',
                    'rooms_features' => 'nullable|array', // Accepter un tableau de features
                    'rooms_features.*' => 'nullable|exists:rooms_features,id', // Valider que chaque feature exist
                    'images' => 'nullable|array',
                    'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                ]);
                $roomCategory = RoomsCategory::findOrFail($id);
                $roomCategory->update([
                    'name' => $validatedData['name'],
                    'description' => $validatedData['description'],
                    'price_in_cent' => $validatedData['price_in_cent'],
                    'bed_size' => $validatedData['bed_size'],
                ]);

                // Si des features sont fournies, les associer à la catégorie
                if (isset($validatedData['rooms_features'])) {
                    $roomCategory->features()->sync($validatedData['rooms_features']);
                }

                if ($request->hasFile('images')) {
                    $existingImages = $roomCategory->images()->get();
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
                            'rooms_category_id' => $roomCategory->id,
                        ]);
                        $image->save();
                    }
                }

                return response()->json($roomCategory->load(['features', 'images']));

            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => 'Category not found',
                    'message' => $e->getMessage(),
                ], 404);
            } catch (ValidationException $e) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while updating the category',
                    'details' => $e->getMessage(),
                ], 500);
            }
        }


        /**
         * Supprime une catégorie de chambre existante.
         */
        public function deleteCategory(int $id): JsonResponse
        {
            try {
                $category = RoomsCategory::findOrFail($id);
                $category->features()->detach();
                $category->delete();

                return response()->json(['message' => 'Catégorie deleted successfully']);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => 'Category not found',
                    'message' => $e->getMessage(),
                ], 404);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while deleting the category',
                    'details' => $e->getMessage(),
                ], 500);
            }
        }
    }
