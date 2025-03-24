<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Service;
use App\Services\ImagesManagementService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    protected ImagesManagementService $imagesManagementService;

    public function __construct(ImagesManagementService $imagesManagementService)
    {
        $this->imagesManagementService = $imagesManagementService;
    }
    /**
     * @OA\Get(
     *     path="/api/service/{id}",
     *     summary="Get one service by id",
     *     tags={"Services"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the service",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Service not found"),
     *     @OA\Response(response=500, description="An error occured")
     * )
     */
    public function getSingleService(int $id): object {
        try {
            // le with permet d'afficher les images liées au service sous forme de tableau
            $service = Service::with(['images', 'language'])->findOrFail($id);
            return response()->json($service);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Service not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the service',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/service/lang-{lang}",
     *     summary="Get all servicesby language selected",
     *     tags={"Services"},
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
    public function getAllServicesByLang(int $lang): JsonResponse
    {
        try {
            $services = Service::where('language_id', $lang)->with(['images', 'language'])->get();
            return response()->json($services);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the services',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/service",
     *     summary="Get all services",
     *     tags={"Services"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occured")
     * )
     */
    public function getAllServices(): JsonResponse
    {
        try {
            $services = Service::with(['images', 'language'])->get();
            return response()->json($services);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the services',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/service",
     *     summary="Add a service",
     *     tags={"Services"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name", "title", "short_description", "description", "link", "price_in_cent", "duration_in_day", "is_per_person", "display_order", "language_id"},
     *                    @OA\Property(
     *                        property="name",
     *                        type="string",
     *                        description="The name to group with other languages"
     *                    ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="The title of the service"
     *                  ),
     *                   @OA\Property(
     *                       property="short_description",
     *                       type="string",
     *                       description="The short_description of the service"
     *                   ),
     *                   @OA\Property(
     *                       property="description",
     *                       type="string",
     *                       description="The description of the service"
     *                   ),
     *                   @OA\Property(
     *                       property="link",
     *                       type="string",
     *                       description="The link of the service"
     *                   ),
     *                  @OA\Property(
     *                      property="price_in_cent",
     *                      type="integer",
     *                      description="The price in cent, 1000 = 10.00$",
     *                      minimum=0
     *                  ),
     *                  @OA\Property(
     *                      property="duration_in_day",
     *                      type="integer",
     *                      description="The duration of the service in days",
     *                      minimum=1
     *                  ),
     *                  @OA\Property(
     *                      property="is_per_person",
     *                      type="integer",
     *                      description="If the price is per person or not true or false"
     *                  ),
     *                   @OA\Property(
     *                       property="display_order",
     *                       type="integer",
     *                       description="The desired disaly order the items should be"
     *                   ),
     *                   @OA\Property(
     *                       property="language_id",
     *                       type="integer",
     *                       description="The ID of the language"
     *                   ),
     *                  @OA\Property(
     *                      property="images[]",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          format="binary",
     *                          description="An array of image files"
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addService(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:50',
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'link' => 'nullable|string|max:50',
                'price_in_cent' => 'bail|required|numeric|min:0',
                'duration_in_day' => 'bail|required|numeric|min:1',
                'is_per_person' => 'bail|nullable|boolean',
                'display_order' => 'bail|required|integer',
                'language_id' => 'bail|required|numeric|exists:languages,id',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',// vérifie que les éléments sont des images
            ]);

            // n'enregistre que les fields de service
            $service = new Service([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
                'link' => $validatedData['link'],
                'price_in_cent' => $validatedData['price_in_cent'],
                'duration_in_day' => $validatedData['duration_in_day'],
                'is_per_person' => $validatedData['is_per_person'],
                'display_order' => $validatedData['display_order'],
                'language_id' => $validatedData['language_id'],
            ]);
            $service->save();

            $this->imagesManagementService->addImages($request, $service, 'service_id');

            return response()->json($service->load(['images', 'language']), 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the news article',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/service/{id}",
     *     summary="Update a service by id",
     *     tags={"Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the service",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name", "title", "short_description", "description", "link", "price_in_cent", "duration_in_day", "is_per_person", "display_order", "language_id"},
     *                    @OA\Property(
     *                        property="name",
     *                        type="string",
     *                        description="The name to group with other languages"
     *                    ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="The title of the service"
     *                  ),
     *                    @OA\Property(
     *                        property="short_description",
     *                        type="string",
     *                        description="The short_description of the service"
     *                    ),
     *                    @OA\Property(
     *                        property="description",
     *                        type="string",
     *                        description="The description of the service"
     *                    ),
     *                    @OA\Property(
     *                        property="link",
     *                        type="string",
     *                        description="The link of the service"
     *                    ),
     *                  @OA\Property(
     *                      property="price_in_cent",
     *                      type="integer",
     *                      description="The price in cent, 1000 = 10.00$",
     *                      minimum=0
     *                  ),
     *                  @OA\Property(
     *                      property="duration_in_day",
     *                      type="integer",
     *                      description="The duration of the service in days",
     *                      minimum=1
     *                  ),
     *                  @OA\Property(
     *                      property="is_per_person",
     *                      type="integer",
     *                      description="If the price is per person or not true or false"
     *                  ),
     *                   @OA\Property(
     *                       property="display_order",
     *                       type="integer",
     *                       description="The desired disaly order the items should be"
     *                   ),
     *                  @OA\Property(
     *                      property="language_id",
     *                      type="integer",
     *                      description="The ID of the language"
     *                  ),
     *                  @OA\Property(
     *                      property="images[]",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string",
     *                          format="binary",
     *                          description="An array of image files"
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Service not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateService(Request $request, String $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:50',
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'link' => 'nullable|string|max:50',
                'price_in_cent' => 'bail|required|numeric|min:0',
                'duration_in_day' => 'bail|required|numeric|min:1',
                'is_per_person' => 'bail|required|boolean',
                'display_order' => 'bail|required|integer',
                'language_id' => 'bail|required|numeric|exists:languages,id',
                'images' => 'nullable|array',
                'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',
            ]);
            $service = Service::findOrFail($id);
            $service->update([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
                'link' => $validatedData['link'],
                'price_in_cent' => $validatedData['price_in_cent'],
                'duration_in_day' => $validatedData['duration_in_day'],
                'is_per_person' => $validatedData['is_per_person'],
                'display_order' => $validatedData['display_order'],
                'language_id' => $validatedData['language_id'],
            ]);

            $this->imagesManagementService->updateImages($request, $service, 'service_id');


            return response()->json([
                'updatedService' => $service->load(['images', 'language']),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Service not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the Service',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/service/{id}",
     *     summary="Delete a service by id",
     *     tags={"Services"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the service",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Service not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteService(String $id): JsonResponse
    {
        try {
            $service = Service::findOrFail($id);

            $this->imagesManagementService->deleteImages($service);

            $service->delete();

            return response()->json(['message' => 'service deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Service not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the service',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
