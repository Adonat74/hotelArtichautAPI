<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Language;
use App\Services\ErrorsService;
use App\Services\ImagesManagementService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LanguageController extends Controller
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
     *     path="/api/language/{id}",
     *     summary="Get one language by id- need to be authentified and role = master",
     *     tags={"Languages"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the language",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Language not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getSingleLanguage(int $id): JsonResponse
    {
        try {
            $language = Language::with(['image'])->findOrFail($id);
            return response()->json($language);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('language', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('language', $e);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/language",
     *     summary="Get all languages- need to be authentified and role = master",
     *     tags={"Languages"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllLanguages(): JsonResponse
    {
        try {
            $languages = Language::with(['image'])->get();
            return response()->json($languages);
        } catch (Exception $e) {
            return $this->errorsService->exception('language', $e);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/language",
     *     summary="Add language- need to be authentified and role = master",
     *     tags={"Languages"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"lang", "image"},
     *                  @OA\Property(
     *                      property="lang",
     *                      type="string",
     *                      description="The language"
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      type="string",
     *                      format="binary",
     *                      description="The language image"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addLanguage(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'lang' => 'bail|required|string|max:25',
                'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $language = new Language([
                'lang' => $validatedData['lang']
            ]);
            $language->save();

            $this->imagesManagementService->addSingleImage($request, $language, 'language_id');

            return response()->json($language->load(['image']), 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('language', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('language', $e);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/language/{id}",
     *     summary="Update language by id- need to be authentified and role = master",
     *     tags={"Languages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the language",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"lang", "image"},
     *                  @OA\Property(
     *                      property="lang",
     *                      type="string",
     *                      description="The language"
     *                  ),
     *                  @OA\Property(
     *                      property="image",
     *                      type="string",
     *                      format="binary",
     *                      description="The language image"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Language not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateLanguage(Request $request, string $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'lang' => 'bail|required|string|max:25',
                'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $language = Language::findOrFail($id);
            $language->update([
                'lang' => $validatedData['lang']
            ]);

            $this->imagesManagementService->updateSingleImage($request, $language, 'language_id');

            return response()->json($language->load(['image']));
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('language', $e);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('language', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('language', $e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/language/{id}",
     *     summary="Delete language by id- need to be authentified and role = master",
     *     tags={"Languages"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the language",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Language not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteLanguage(string $id): JsonResponse
    {
        try {
            $language = Language::findOrFail($id);

            $this->imagesManagementService->deleteSingleImage($language);

            $language->delete();

            return response()->json(['message' => 'language deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('language', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('language', $e);
        }
    }
}
