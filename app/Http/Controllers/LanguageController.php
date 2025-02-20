<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Language;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LanguageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/language/{id}",
     *     summary="Get one language by id",
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
            return response()->json([
                'error' => 'Language not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the language',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/language",
     *     summary="Get all languages",
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
            return response()->json([
                'error' => 'An error occurred while fetching the languages',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/language",
     *     summary="Add language",
     *     tags={"Languages"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
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
                'lang' => 'bail|required|string|max:5',
                'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $language = new Language([
                'lang' => $validatedData['lang']
            ]);
            $language->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('images', 'public');
                $image = new Image([
                    'url' => url('storage/' . $imagePath),
                    'content_id' => $language->id,
                ]);
                $image->save();
            }

            return response()->json($language->load(['image']), 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $exception->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the language',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/language/{id}",
     *     summary="Update language by id",
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
     *
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
                'lang' => 'bail|required|string|max:5',
                'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $language = Language::findOrFail($id);
            $language->update([
                'lang' => $validatedData['lang']
            ]);

            if ($request->hasFile('image')) {
                $existingImage = $language->image()->get();

                if ($existingImage) {
                    Storage::disk('public')->delete($existingImage->url);
                    $existingImage->delete();
                }

                $image = $request->file('image');
                $imagePath = $image->store('images', 'public');
                $image = new Image([
                    'url' => url('storage/' . $imagePath),
                    'content_id' => $language->id,
                ]);
                $image->save();
            }

            return response()->json($language->load(['image']));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Language not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $exception->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the language',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/language/{id}",
     *     summary="Delete language by id",
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
            $existingImage = $language->image()->get();

            if ($existingImage) {
                Storage::disk('public')->delete($existingImage->url);
                $existingImage->delete();

            }


            $language->delete();

            return response()->json(['message' => 'language deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Language not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the language',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
