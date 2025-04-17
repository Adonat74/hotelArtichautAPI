<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Image;
use App\Models\Service;
use App\Services\ErrorsService;
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
    protected ErrorsService $errorsService;

    public function __construct(
        ImagesManagementService $imagesManagementService,
        ErrorsService $errorsService
    )
    {
        $this->imagesManagementService = $imagesManagementService;
        $this->errorsService = $errorsService;
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
            return $this->errorsService->modelNotFoundException('service', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('service', $e);
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
            return $this->errorsService->exception('service', $e);
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
            return $this->errorsService->exception('service', $e);
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
    public function addService(ServiceRequest $request): JsonResponse
    {
        try {
            // n'enregistre que les fields de service
            $service = new Service($request->safe()->except(['images']));
            $service->save();

            $this->imagesManagementService->addImages($request, $service, 'service_id');

            return response()->json($service->load(['images', 'language']), 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('service', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('service', $e);
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
    public function updateService(ServiceRequest $request, String $id): JsonResponse
    {
        try {
            $service = Service::findOrFail($id);
            $service->update($request->safe()->except(['images']));

            $this->imagesManagementService->updateImages($request, $service, 'service_id');


            return response()->json([
                'updatedService' => $service->load(['images', 'language']),
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('service', $e);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('service', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('service', $e);
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
            return $this->errorsService->modelNotFoundException('service', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('service', $e);
        }
    }
}
