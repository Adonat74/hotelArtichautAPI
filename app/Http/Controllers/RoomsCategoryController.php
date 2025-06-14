<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\RoomsCategoryRequest;
    use App\Models\RoomsCategory;
    use App\Services\AttachService;
    use App\Services\ErrorsService;
    use App\Services\ImagesManagementService;
    use App\Services\SyncService;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;

    class RoomsCategoryController extends Controller
    {
        protected ImagesManagementService $imagesManagementService;
        protected ErrorsService $errorsService;
        protected SyncService $syncService;
        protected AttachService $attachService;

        public function __construct(
            ImagesManagementService $imagesManagementService,
            ErrorsService $errorsService,
            SyncService $syncService,
            AttachService $attachService,
        )
        {
            $this->imagesManagementService = $imagesManagementService;
            $this->errorsService = $errorsService;
            $this->syncService = $syncService;
            $this->attachService = $attachService;
        }


        /**
         * @OA\Get(
         *     path="/api/rooms-category/{id}",
         *     summary="Get one rooms-category by id",
         *     tags={"RoomsCategories"},
         *      @OA\Parameter(
         *          name="id",
         *          in="path",
         *          description="The ID of the rooms-category",
         *          required=true,
         *          @OA\Schema(type="integer")
         *      ),
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=404, description="Service not found"),
         *     @OA\Response(response=500, description="An error occured")
         * )
         */
        public function getSingleCategory(int $id): JsonResponse
        {
            try {
                $category = RoomsCategory::with(['features', 'rooms', 'images', 'language'])->findOrFail($id);
                return response()->json($category);
            } catch (ModelNotFoundException $e) {
                return $this->errorsService->modelNotFoundException('category', $e);
            } catch (Exception $e) {
                return $this->errorsService->exception('category', $e);
            }
        }




        /**
         * @OA\Get(
         *     path="/api/rooms-category/lang-{lang}",
         *     summary="Get all rooms-category by lang",
         *     tags={"RoomsCategories"},
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
        public function getAllCategoriesByLang(int $lang): JsonResponse
        {
            try {
                $categories = RoomsCategory::where('language_id', $lang)->with(['features', 'rooms', 'images', 'language'])->get();
                return response()->json($categories);
            } catch (Exception $e) {
                return $this->errorsService->exception('category', $e);
            }
        }

        /**
         * @OA\Get(
         *     path="/api/rooms-category",
         *     summary="Get all rooms-category",
         *     tags={"RoomsCategories"},
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=500, description="An error occured")
         * )
         */
        public function getAllCategories(): JsonResponse
        {
            try {
                $categories = RoomsCategory::with(['features', 'rooms', 'images', 'language'])->get();
                return response()->json($categories);
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'An error occurred while fetching the categories',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }



        /**
         * @OA\Post(
         *     path="/api/rooms-category",
         *     summary="Add a rooms-category article",
         *     tags={"RoomsCategories"},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\MediaType(
         *             mediaType="multipart/form-data",
         *             @OA\Schema(
         *                 required={"name", "category_name", "description", "price_in_cent", "bed_size", "display_order", "language_id"},
         *                    @OA\Property(
         *                        property="name",
         *                        type="string",
         *                        description="The name to group with other languages"
         *                    ),
         *                 @OA\Property(
         *                     property="category_name",
         *                     type="string",
         *                     description="The category_name of the rooms-category article",
         *                     example="Deluxe Room"
         *                 ),
         *                 @OA\Property(
         *                     property="description",
         *                     type="string",
         *                     description="Description of the rooms-category article",
         *                     example="A luxurious room with a sea view."
         *                 ),
         *                 @OA\Property(
         *                     property="price_in_cent",
         *                     type="integer",
         *                     description="The price in cents",
         *                     example=15000
         *                 ),
         *                 @OA\Property(
         *                     property="bed_size",
         *                     type="integer",
         *                     description="The bed size as an integer value",
         *                     example=2
         *                 ),
         *                 @OA\Property(
         *                     property="rooms_features[]",
         *                     type="array",
         *                     description="An array of rooms_feature IDs",
         *                     @OA\Items(type="integer", example=3)
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
         *                     property="images[]",
         *                     type="array",
         *                     description="An array of image files",
         *                     @OA\Items(
         *                         type="string",
         *                         format="binary"
         *                     )
         *                 )
         *             )
         *         )
         *     ),
         *     @OA\Response(response=201, description="Successful operation"),
         *     @OA\Response(response=422, description="Validation failed"),
         *     @OA\Response(response=500, description="An error occurred")
         * )
         */

        public function addCategory(RoomsCategoryRequest $request): JsonResponse
        {
            try {
                $validatedData = $request->validated();
                $roomCategory = new RoomsCategory($request->safe()->except(['rooms_features', 'images']));
                $roomCategory->save();

                // Si des features sont fournies, les associer à la catégorie
                $this->attachService->attachFeatureModel($roomCategory, $validatedData['rooms_features']);

                $this->imagesManagementService->addImages($request, $roomCategory, 'rooms_category_id');

                // Retourne une réponse JSON avec les données enregistrées
                return response()->json($roomCategory->load(['features', 'rooms', 'images', 'language']), 201);
            } catch (ValidationException $e) {
                return $this->errorsService->validationException('category', $e);
            } catch (Exception $e) {
                return $this->errorsService->exception('category', $e);
            }
        }



        /**
         * @OA\Post(
         *     path="/api/rooms-category/{id}",
         *     summary="Update a rooms-category article by id",
         *     tags={"RoomsCategories"},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         description="The ID of the rooms-category article",
         *         required=true,
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\MediaType(
         *             mediaType="multipart/form-data",
         *             @OA\Schema(
         *                 required={"name", "category_name", "description", "price_in_cent", "bed_size", "display_order", "language_id"},
         *                    @OA\Property(
         *                        property="name",
         *                        type="string",
         *                        description="The name to group with other languages"
         *                    ),
         *                 @OA\Property(
         *                     property="category_name",
         *                     type="string",
         *                     description="The category_name of the rooms-category article",
         *                     example="Deluxe Room"
         *                 ),
         *                 @OA\Property(
         *                     property="description",
         *                     type="string",
         *                     description="Description of the rooms-category article",
         *                     example="A luxurious room with a sea view."
         *                 ),
         *                 @OA\Property(
         *                     property="price_in_cent",
         *                     type="integer",
         *                     description="The price in cents",
         *                     example=15000
         *                 ),
         *                 @OA\Property(
         *                     property="bed_size",
         *                     type="integer",
         *                     description="The bed size as an integer value",
         *                     example=2
         *                 ),
         *                 @OA\Property(
         *                     property="rooms_features[]",
         *                     type="array",
         *                     description="An array of rooms_feature IDs",
         *                     @OA\Items(type="integer", example=3)
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
         *                     property="images[]",
         *                     type="array",
         *                     description="An array of image files",
         *                     @OA\Items(
         *                         type="string",
         *                         format="binary"
         *                     )
         *                 )
         *             )
         *         )
         *     ),
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=404, description="RoomsCategories not found"),
         *     @OA\Response(response=422, description="Validation failed"),
         *     @OA\Response(response=500, description="An error occurred")
         * )
         */

        public function updateCategory(RoomsCategoryRequest $request, $id): JsonResponse
        {
            try {
                $validatedData = $request->validated();
                $roomCategory = RoomsCategory::findOrFail($id);
                $roomCategory->update($request->safe()->except(['rooms_features', 'images']));

                // Si des features sont fournies, les associer à la catégorie
                $this->syncService->syncFeatureModel($roomCategory, $validatedData['rooms_features']);


                $this->imagesManagementService->updateImages($request, $roomCategory, 'rooms_category_id');


                return response()->json($roomCategory->load(['features',  'rooms', 'images', 'language']));
            } catch (ModelNotFoundException $e) {
                return $this->errorsService->modelNotFoundException('category', $e);
            } catch (ValidationException $e) {
                return $this->errorsService->validationException('category', $e);
            } catch (Exception $e) {
                return $this->errorsService->exception('category', $e);
            }
        }


        /**
         * @OA\Delete(
         *     path="/api/rooms-category/{id}",
         *     summary="Delete a rooms-category article by id",
         *     tags={"RoomsCategories"},
         *      @OA\Parameter(
         *          name="id",
         *          in="path",
         *          description="The ID of the rooms-category article",
         *          required=true,
         *          @OA\Schema(type="integer")
         *      ),
         *     @OA\Response(response=200, description="Successful operation"),
         *     @OA\Response(response=404, description="RoomsCategories not found"),
         *     @OA\Response(response=500, description="An error occurred")
         * )
         */
        public function deleteCategory(int $id): JsonResponse
        {
            try {
                $category = RoomsCategory::findOrFail($id);
                $category->features()->detach();

                $this->imagesManagementService->deleteImages($category);


                $category->delete();

                return response()->json(['message' => 'Catégorie deleted successfully']);
            } catch (ModelNotFoundException $e) {
                return $this->errorsService->modelNotFoundException('category', $e);
            } catch (Exception $e) {
                return $this->errorsService->exception('category', $e);
            }
        }
    }
