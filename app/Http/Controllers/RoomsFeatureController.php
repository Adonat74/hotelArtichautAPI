<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\RoomsFeatureRequest;
    use App\Models\RoomsFeature;
    use App\Services\AttachService;
    use App\Services\ErrorsService;
    use App\Services\SyncService;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;

    class RoomsFeatureController extends Controller
    {

        protected ErrorsService $errorsService;
        protected SyncService $syncService;
        protected AttachService $attachService;
        public function __construct(
            ErrorsService $errorsService,
            SyncService $syncService,
            AttachService $attachService,
        )
        {
            $this->errorsService = $errorsService;
            $this->syncService = $syncService;
            $this->attachService = $attachService;
        }

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
                return $this->errorsService->modelNotFoundException('feature', $e);
            } catch (Exception $e) {
                return $this->errorsService->exception('feature', $e);
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
                return $this->errorsService->exception('feature', $e);
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
                return $this->errorsService->exception('feature', $e);
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

        public function addFeature(RoomsFeatureRequest $request): JsonResponse
        {
            try {
                $validatedData = $request->validated();
                $feature = new RoomsFeature($validatedData);
                $feature->save();

                // Attachez les catégories à l'équipement
                $this->attachService->attachRelatedModel($feature, $validatedData['rooms_categories']);

                // Retourne une réponse JSON avec les données enregistrées
                return response()->json($feature->load(['roomsCategories', 'language']), 201);
            } catch (ValidationException $e) {
                return $this->errorsService->validationException('feature', $e);
            } catch (Exception $e) {
                return $this->errorsService->exception('feature', $e);
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
        public function updateFeature(RoomsFeatureRequest $request, string $id): JsonResponse
        {
            try {
                $validatedData = $request->validated();
                $feature = RoomsFeature::findOrFail($id);
                $feature->update($validatedData);

                $this->syncService->syncRelatedModel($feature, $validatedData['rooms_categories']);

                return response()->json($feature->load(['roomsCategories', 'language']));

            } catch (ModelNotFoundException $e) {
                return $this->errorsService->modelNotFoundException('feature', $e);
            } catch (ValidationException $e) {
                return $this->errorsService->validationException('feature', $e);
            } catch (Exception $e) {
                return $this->errorsService->exception('feature', $e);
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
                return $this->errorsService->modelNotFoundException('feature', $e);
            } catch (Exception $e) {
                return $this->errorsService->exception('feature', $e);
            }
        }
    }
