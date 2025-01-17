<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\NewsArticle;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class NewsArticleController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/news/{id}",
     *     summary="Get one news by id",
     *     tags={"News"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the news",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Service not found"),
     *     @OA\Response(response=500, description="An error occured")
     * )
     */
    public function getSingleNewsArticle(int $id): object {
        try {
            // le with permet d'afficher les images liées au service sous forme de tableau
            $newsArticle = NewsArticle::with('images')->findOrFail($id);
            return response()->json([
                'newsArticle'=>$newsArticle,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'News not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the news',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/news",
     *     summary="Get all news",
     *     tags={"News"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occured")
     * )
     */
    public function getAllNewsArticle(): JsonResponse
    {
        try {
            $newsArticles = NewsArticle::with('images')->get();
            return response()->json([
                'newsArticles'=>$newsArticles,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the news articles',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/news",
     *     summary="Add a news article",
     *     tags={"News"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"title", "short_description", "description", "images[]"},
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="The title of the news article"
     *                  ),
     *                  @OA\Property(
     *                      property="short_description",
     *                      type="string",
     *                      description="Short description of the news article"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Full description of the news article"
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
    public function addNewsArticle(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $newsArticle = new NewsArticle([
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
            ]);
            $newsArticle->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => $imagePath,
                        'news_article_id' => $newsArticle->id,
                    ]);
                    $image->save();
                }
            }

            return response()->json([
                'addedNews' => $newsArticle->load('images'),
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $exception->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the news article',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/news/{id}",
     *     summary="Update a news article by id",
     *     tags={"News"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the news article",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"title", "short_description", "description", "images[]"},
     *                  @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      description="The title of the news article"
     *                  ),
     *                  @OA\Property(
     *                      property="short_description",
     *                      type="string",
     *                      description="Short description of the news article"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Full description of the news article"
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
     *     @OA\Response(response=404, description="News not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateNewsArticle(Request $request, String $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $newsArticle = NewsArticle::findOrFail($id);
            $newsArticle->update([
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
            ]);

            if ($request->hasFile('images')) {
                $existingImages = $newsArticle->images()->get();

                // Delete existing images
                foreach ($existingImages as $existingImage) {
                    Storage::disk('public')->delete($existingImage->url);
                    $existingImage->delete();
                }

                // Store new images
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $newImage = new Image([
                        'url' => $imagePath,
                        'news_article_id' => $newsArticle->id,
                    ]);
                    $newImage->save();
                }
            }

            return response()->json([
                'updatedNews' => $newsArticle->load('images'),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'News not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $exception->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the news article',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/news/{id}",
     *     summary="Delete a news article by id",
     *     tags={"News"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the news article",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="News not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteNewsArticle(String $id): JsonResponse
    {
        try {
            $newsArticle = NewsArticle::findOrFail($id);
            $existingImages = $newsArticle->images()->get();

            // Delete existing images
            foreach ($existingImages as $existingImage) {
                Storage::disk('public')->delete($existingImage->url);
                $existingImage->delete();
            }

            $newsArticle->delete();

            return response()->json(['deletedNewsArticle' => $newsArticle]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'News not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the news article',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
