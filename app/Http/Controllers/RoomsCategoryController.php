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
                return response()->json([
                    'error' => 'An error occurred while fetching the categories',
                    'message' => $e->getMessage(),
                ], 500);
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

        public function addCategory(Request $request): JsonResponse
        {
            try {
                $validatedData = $request->validate([
                    'name' => 'bail|required|string|max:50',
                    'category_name' => 'bail|required|string|max:255',
                    'description' => 'bail|required|string|max:1000',
                    'price_in_cent' => 'bail|required|integer',
                    'bed_size' => 'bail|required|integer',
                    'display_order' => 'bail|required|integer',
                    'language_id' => 'bail|required|numeric|exists:languages,id',
                    'rooms_features' => 'nullable|array', // Accepter un tableau de features
                    'rooms_features.*' => 'nullable|exists:rooms_features,id', // Valider que chaque feature exist
                    'images' => 'nullable|array',
                    'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',
                ]);
                $roomCategory = new RoomsCategory([
                    'name' => $validatedData['name'],
                    'category_name' => $validatedData['category_name'],
                    'description' => $validatedData['description'],
                    'price_in_cent' => $validatedData['price_in_cent'],
                    'bed_size' => $validatedData['bed_size'],
                    'display_order' => $validatedData['display_order'],
                    'language_id' => $validatedData['language_id'],
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
                return response()->json($roomCategory->load(['features', 'rooms', 'images', 'language']), 201);
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

        public function updateCategory(Request $request, $id): JsonResponse
        {
            try {
                $validatedData = $request->validate([
                    'name' => 'bail|required|string|max:50',
                    'category_name' => 'bail|required|string|max:255',
                    'description' => 'bail|required|string|max:1000',
                    'price_in_cent' => 'bail|required|integer',
                    'bed_size' => 'bail|required|integer',
                    'display_order' => 'bail|required|integer',
                    'language_id' => 'bail|required|numeric|exists:languages,id',
                    'rooms_features' => 'nullable|array', // Accepter un tableau de features
                    'rooms_features.*' => 'nullable|exists:rooms_features,id', // Valider que chaque feature exist
                    'images' => 'nullable|array',
                    'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',
                ]);
                $roomCategory = RoomsCategory::findOrFail($id);
                $roomCategory->update([
                    'name' => $validatedData['name'],
                    'category_name' => $validatedData['category_name'],
                    'description' => $validatedData['description'],
                    'price_in_cent' => $validatedData['price_in_cent'],
                    'bed_size' => $validatedData['bed_size'],
                    'display_order' => $validatedData['display_order'],
                    'language_id' => $validatedData['language_id'],
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

                return response()->json($roomCategory->load(['features',  'rooms', 'images', 'language']));
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
