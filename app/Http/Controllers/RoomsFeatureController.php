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
         * @OA\Get(
         *     path="/api/rooms-feature/{id}",
         *     summary="Get one rooms-feature by id",
         *     tags={"RoomsFeatures"},
         *      @OA\Parameter(
         *          name="id",
         *          in="path",
         *          description="The ID of the rooms-feature",
         *          required=true,
         *          @OA\Schema(type="integer")
         *      ),
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=404, description="Service not found"),
         *     @OA\Response(response=500, description="An error occured")
         * )
         */
        public function getSingleFeature(int $id): JsonResponse
        {
            try {
                $feature = RoomsFeature::with(['roomsCategories', 'language'])->findOrFail($id);
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




        /**
         * @OA\Get(
         *     path="/api/rooms-feature/lang-{lang}",
         *     summary="Get all rooms-feature by lang",
         *     tags={"RoomsFeatures"},
         *       @OA\Parameter(
         *            name="lang",
         *            in="path",
         *            description="The lang desired",
         *            required=true,
         *            @OA\Schema(type="integer")
         *       ),
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=500, description="An error occured")
         * )
         */
        public function getAllFeaturesByLang(int $lang): JsonResponse{
            try {
                $features = RoomsFeature::where('language_id', $lang)->with(['roomsCategories', 'language'])->get();
                return response()->json($features);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while fetching the features',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }

        /**
         * @OA\Get(
         *     path="/api/rooms-feature",
         *     summary="Get all rooms-feature",
         *     tags={"RoomsFeatures"},
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=500, description="An error occured")
         * )
         */
        public function getAllFeatures(): JsonResponse{
            try {
                $features = RoomsFeature::with(['roomsCategories', 'language'])->get();
                return response()->json($features);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while fetching the features',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }


        /**
         * @OA\Post(
         *     path="/api/rooms-feature",
         *     summary="Add a rooms-feature",
         *     tags={"RoomsFeatures"},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\MediaType(
         *             mediaType="multipart/form-data",
         *             @OA\Schema(
         *                 required={"name", "feature_name", "description", "display_order", "language_id"},
         *                    @OA\Property(
         *                        property="name",
         *                        type="string",
         *                        description="The name to group with other languages"
         *                    ),
         *                 @OA\Property(
         *                     property="feature_name",
         *                     type="string",
         *                     description="The feature_name of the rooms-feature ",
         *                     example="Ocean View"
         *                 ),
         *                 @OA\Property(
         *                     property="description",
         *                     type="string",
         *                     description="Description of the rooms-feature ",
         *                     example="A feature describing the ocean view from the room."
         *                 ),
         *                   @OA\Property(
         *                       property="display_order",
         *                       type="integer",
         *                       description="The desired disaly order the items should be"
         *                   ),
         *                 @OA\Property(
         *                     property="language_id",
         *                     type="integer",
         *                     description="The ID of the language"
         *                 ),
         *                 @OA\Property(
         *                     property="rooms_categories[]",
         *                     type="array",
         *                     description="An array of rooms_category IDs",
         *                     @OA\Items(type="integer", example=2)
         *                 )
         *             )
         *         )
         *     ),
         *     @OA\Response(response=201, description="Successful operation"),
         *     @OA\Response(response=422, description="Validation failed"),
         *     @OA\Response(response=500, description="An error occurred")
         * )
         */

        public function addFeature(Request $request): JsonResponse
        {

            try {
                $validatedData = $request->validate([
                    'name' => 'bail|required|string|max:50',
                    'feature_name' => 'bail|required|string|max:100',
                    'description' => 'bail|required|string|max:1000',
                    'display_order' => 'bail|required|integer',
                    'language_id' => 'bail|required|numeric|exists:languages,id',
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
                return response()->json($feature->load(['roomsCategories', 'language']), 201);
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
         * @OA\Post(
         *     path="/api/rooms-feature/{id}",
         *     summary="Update a rooms-feature  by id",
         *     tags={"RoomsFeatures"},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         description="The ID of the rooms-feature ",
         *         required=true,
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\MediaType(
         *             mediaType="multipart/form-data",
         *             @OA\Schema(
         *                 required={"name", "feature_name", "description", "display_order", "language_id"},
         *                    @OA\Property(
         *                        property="name",
         *                        type="string",
         *                        description="The name to group with other languages"
         *                    ),
         *                 @OA\Property(
         *                     property="feature_name",
         *                     type="string",
         *                     description="The feature_name of the rooms-feature ",
         *                     example="Ocean View"
         *                 ),
         *                 @OA\Property(
         *                     property="description",
         *                     type="string",
         *                     description="Description of the rooms-feature ",
         *                     example="A feature describing the ocean view from the room."
         *                 ),
         *                   @OA\Property(
         *                       property="display_order",
         *                       type="integer",
         *                       description="The desired disaly order the items should be"
         *                   ),
         *                 @OA\Property(
         *                     property="language_id",
         *                     type="integer",
         *                     description="The ID of the language"
         *                 ),
         *                 @OA\Property(
         *                     property="rooms_categories[]",
         *                     type="array",
         *                     description="An array of rooms_category IDs",
         *                     @OA\Items(type="integer", example=2)
         *                 )
         *             )
         *         )
         *     ),
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=404, description="RoomsFeature not found"),
         *     @OA\Response(response=422, description="Validation failed"),
         *     @OA\Response(response=500, description="An error occurred")
         *)
         */
        public function updateFeature(Request $request, string $id): JsonResponse
        {
            try {
                $validatedData = $request->validate([
                    'name' => 'bail|required|string|max:50',
                    'feature_name' => 'required|string|max:100',
                    'description' => 'required|string|max:1000',
                    'display_order' => 'bail|required|integer',
                    'language_id' => 'bail|required|numeric|exists:languages,id',
                    'rooms_categories' => 'nullable|array',  // Validation des catégories
                    'rooms_categories.*' => 'nullable|exists:rooms_categories,id',
                ]);
                $feature = RoomsFeature::findOrFail($id);
                $feature->update($validatedData);

                if (isset($validatedData['rooms_categories'])) {
                    $feature->roomsCategories()->sync($validatedData['rooms_categories']);
                }

                return response()->json($feature->load(['roomsCategories', 'language']));

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
         * @OA\Delete(
         *     path="/api/rooms-feature/{id}",
         *     summary="Delete a rooms-feature  by id",
         *     tags={"RoomsFeatures"},
         *      @OA\Parameter(
         *          name="id",
         *          in="path",
         *          description="The ID of the rooms-feature ",
         *          required=true,
         *          @OA\Schema(type="integer")
         *      ),
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=404, description="RoomsFeature not found"),
         *     @OA\Response(response=500, description="An error occurred")
         * )
         */
        public function deleteFeature(int $id): JsonResponse
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
