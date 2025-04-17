<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsArticleRequest;
use App\Models\Image;
use App\Models\NewsArticle;
use App\Services\ErrorsService;
use App\Services\ImagesManagementService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class NewsArticleController extends Controller
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
            $newsArticle = NewsArticle::with(['images', 'language'])->findOrFail($id);
            return response()->json($newsArticle);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('news', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('news', $e);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/news/lang-{lang}",
     *     summary="Get all news",
     *     tags={"News"},
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
    public function getAllNewsArticlesByLang(int $lang): JsonResponse
    {
        try {
            $newsArticles = NewsArticle::where('language_id', $lang)->with(['images', 'language'])->get();
            return response()->json($newsArticles);
        } catch (Exception $e) {
            return $this->errorsService->exception('news', $e);
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
    public function getAllNewsArticles(): JsonResponse
    {
        try {
            $newsArticles = NewsArticle::with(['images', 'language'])->get();
            return response()->json($newsArticles);
        } catch (Exception $e) {
            return $this->errorsService->exception('news', $e);
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
     *                  required={"name", "title", "short_description", "description", "display_order", "language_id"},
     *                    @OA\Property(
     *                        property="name",
     *                        type="string",
     *                        description="The name to group with other languages"
     *                    ),
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
    public function addNewsArticle(NewsArticleRequest $request): JsonResponse
    {
        try {
            $newsArticle = new NewsArticle($request->safe()->except(['images']));
            $newsArticle->save();

            $this->imagesManagementService->addImages($request, $newsArticle, 'news_article_id');

            return response()->json($newsArticle->load(['images', 'language']), 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('news', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('news', $e);
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
     *                  required={"name", "title", "short_description", "description", "display_order", "language_id"},
     *                    @OA\Property(
     *                        property="name",
     *                        type="string",
     *                        description="The name to group with other languages"
     *                    ),
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
     *     @OA\Response(response=404, description="News not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateNewsArticle(NewsArticleRequest $request, String $id): JsonResponse
    {
        try {
            $newsArticle = NewsArticle::findOrFail($id);
            $newsArticle->update($request->safe()->except(['images']));

            $this->imagesManagementService->updateImages($request, $newsArticle, 'news_article_id');

            return response()->json($newsArticle->load(['images', 'language']));
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('news', $e);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('news', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('news', $e);

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

            $this->imagesManagementService->deleteImages($newsArticle);

            $newsArticle->delete();

            return response()->json(['message' => 'news deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('news', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('news', $e);
        }
    }
}
