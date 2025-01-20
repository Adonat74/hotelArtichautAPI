<?php

    namespace App\Http\Controllers;

    use App\Models\RoomsFeature;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Validation\ValidationException;

    class RoomsFeatureController extends Controller
    {


        /**
         * Display the specified resource.
         */
        public function getSingleFeature(string $id): JsonResponse
        {
            try {
                $feature = RoomsFeature::with('roomsCategories')->findOrFail($id);
                return response()->json($feature);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => 'Feature not found',
                    'message' => $e->getMessage(),
                ], 404);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while fetching the feature',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }





        public function getAllFeatures(): JsonResponse{
            try {
                $features = RoomsFeature::with('roomsCategories')->get();
                return response()->json($features);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while fetching the features',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }



        /**
         * Store a newly created resource in storage.
         */
        public function addFeature(Request $request): JsonResponse
        {

            try {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:100',
                    'description' => 'required|string|max:1000',
                    'rooms_categories' => 'nullable|array',  // Validation des catégories
                    'rooms_categories.*' => 'nullable|exists:rooms_categories,id',
                ]);
                $feature = new RoomsFeature($validatedData);
                $feature->save();

                // Attachez les catégories à l'équipement
                if (isset($validatedData['rooms_categories'])) {

                    $feature->roomsCategories()->attach($validatedData['rooms_categories']);
                }

                // Retourne une réponse JSON avec les données enregistrées
                return response()->json($feature->load('roomsCategories'), 201);
            } catch (ValidationException $e) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while adding the feature',
                    'details' => $e->getMessage(),
                ], 500);
            }
        }






        /**
         * Update the specified resource in storage.
         */
        public function updateFeature(Request $request, string $id): JsonResponse
        {
            try {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:100',
                    'description' => 'required|string|max:1000',
                    'rooms_categories' => 'nullable|array',  // Validation des catégories
                    'rooms_categories.*' => 'nullable|exists:rooms_categories,id',
                ]);
                $feature = RoomsFeature::findOrFail($id);
                $feature->update($validatedData);

                if (isset($validatedData['rooms_categories'])) {
                    $feature->roomsCategories()->sync($validatedData['rooms_categories']);
                }

                return response()->json($feature->load('roomsCategories'));

            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => 'Feature not found',
                    'message' => $e->getMessage(),
                ], 404);
            } catch (ValidationException $e) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while updating the feature',
                    'details' => $e->getMessage(),
                ], 500);
            }
        }

        /**
         * Remove the specified resource from storage.
         */
        public function deleteFeature(string $id): JsonResponse
        {
            try{
                $feature = RoomsFeature::findOrFail($id);
                $feature->roomsCategories()->detach();
                $feature->delete();
                return response()->json(['message' => 'feature deleted successfully']);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                    'error' => 'Feature not found',
                    'message' => $e->getMessage(),
                ], 404);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while deleting the feature',
                    'details' => $e->getMessage(),
                ],500);
            }
        }
    }
