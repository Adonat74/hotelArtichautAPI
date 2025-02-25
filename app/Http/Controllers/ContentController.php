<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Image;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/content/{id}",
     *     summary="Get one content by id",
     *     tags={"Contents"},
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the content",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="content not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getSingleContent(int $id): JsonResponse
    {
        try {
            $content = Content::with(['images', 'language'])->findOrFail($id);
            return response()->json($content);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'content not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the content',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/content/lang-{lang}",
     *     summary="Get all contents by language selected",
     *     tags={"Contents"},
     *       @OA\Parameter(
     *            name="lang",
     *            in="path",
     *            description="The lang desired",
     *            required=true,
     *            @OA\Schema(type="integer")
     *       ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllContentsByLang(string $lang): JsonResponse
    {
        try {
            $contents = Content::where('language_id', $lang)->with(['images', 'language'])->get();
            return response()->json($contents);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the contents',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/content",
     *     summary="Get all contents",
     *     tags={"Contents"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllContents(): JsonResponse
    {
        try {
            $contents = Content::with(['images', 'language'])->get();
            return response()->json($contents);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the contents',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/content",
     *     summary="Add content",
     *     tags={"Contents"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name", "title", "short_description", "description", "landing_page_display", "navbar_display", "display_order", "language_id"},
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      description="The name of the content"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="The title of the content"
     *                  ),
     *                  @OA\Property(
     *                      property="short_description",
     *                      type="string",
     *                      description="A short description of the content"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="The full description of the content"
     *                  ),
     *                  @OA\Property(
     *                      property="landing_page_display",
     *                      type="integer",
     *                      description="Landing page display option"
     *                  ),
     *                  @OA\Property(
     *                      property="navbar_display",
     *                      type="integer",
     *                      description="Navbar display option"
     *                  ),
     *                  @OA\Property(
     *                      property="display_order",
     *                      type="integer",
     *                      description="The desired disaly order the items should be"
     *                  ),
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
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addContent(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:100',
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'landing_page_display' => 'bail|required|boolean',
                'navbar_display' => 'bail|required|boolean',
                'display_order' => 'bail|required|integer',
                'language_id' => 'bail|required|numeric|exists:languages,id',
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $content = new Content([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
                'landing_page_display' => $validatedData['landing_page_display'],
                'navbar_display' => $validatedData['navbar_display'],
                'display_order' => $validatedData['display_order'],
                'language_id' => $validatedData['language_id'],
            ]);
            $content->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => url('storage/' . $imagePath),
                        'content_id' => $content->id,
                    ]);
                    $image->save();
                }
            }

            return response()->json($content->load(['images', 'language']), 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $exception->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the content',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/content/{id}",
     *     summary="Update content by id",
     *     tags={"Contents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the content",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"name", "title", "short_description", "description", "landing_page_display", "navbar_display", "display_order", "language_id"},
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      description="The name of the content"
     *                  ),
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="The title of the content"
     *                  ),
     *                  @OA\Property(
     *                      property="short_description",
     *                      type="string",
     *                      description="A short description of the content"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="The full description of the content"
     *                  ),
     *                  @OA\Property(
     *                      property="landing_page_display",
     *                      type="integer",
     *                      description="Landing page display option"
     *                  ),
     *                  @OA\Property(
     *                      property="navbar_display",
     *                      type="integer",
     *                      description="Navbar display option"
     *                  ),
     *                  @OA\Property(
     *                      property="display_order",
     *                      type="integer",
     *                      description="The desired disaly order the items should be"
     *                  ),
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
     *     @OA\Response(response=404, description="content not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateContent(Request $request, string $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:100',
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'landing_page_display' => 'bail|required|boolean',
                'navbar_display' => 'bail|required|boolean',
                'display_order' => 'bail|required|integer',
                'language_id' => 'bail|required|numeric|exists:languages,id',
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $content = Content::findOrFail($id);
            $content->update([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
                'landing_page_display' => $validatedData['landing_page_display'],
                'navbar_display' => $validatedData['navbar_display'],
                'display_order' => $validatedData['display_order'],
                'language_id' => $validatedData['language_id'],
            ]);

            if ($request->hasFile('images')) {
                $existingImages = $content->images()->get();

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
                        'content_id' => $content->id,
                    ]);
                    $image->save();
                }
            }

            return response()->json($content->load(['images', 'language']));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'content not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $exception->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the content',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/content/{id}",
     *     summary="Delete content by id",
     *     tags={"Contents"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the content",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="content not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteContent(string $id): JsonResponse
    {
        try {
            $content = Content::findOrFail($id);
            $existingImages = $content->images()->get();

            if ($existingImages) {
                foreach ($existingImages as $existingImage) {
                    Storage::disk('public')->delete($existingImage->url);
                    $existingImage->delete();
                }
            }

            $content->delete();

            return response()->json(['message' => 'content deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'content not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the content',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
