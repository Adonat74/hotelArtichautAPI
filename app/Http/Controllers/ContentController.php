<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Image;
use App\Services\ErrorsService;
use App\Services\ImagesManagementService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
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
            return $this->errorsService->modelNotFoundException('content', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('content', $e);
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
            return $this->errorsService->exception('content', $e);
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
            return $this->errorsService->exception('content', $e);
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
     *                      property="link",
     *                      type="string",
     *                      description="a button or link"
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
                'link' => 'nullable|string',
                'display_order' => 'bail|required|integer',
                'language_id' => 'bail|required|numeric|exists:languages,id',
                'images' => 'nullable|array',
                'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',
            ]);

            $content = new Content([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
                'landing_page_display' => $validatedData['landing_page_display'],
                'navbar_display' => $validatedData['navbar_display'],
                'link' => $validatedData['link'],
                'display_order' => $validatedData['display_order'],
                'language_id' => $validatedData['language_id'],
            ]);
            $content->save();

            $this->imagesManagementService->addImages($request, $content, 'content_id');

            return response()->json($content->load(['images', 'language']), 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('content', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('content', $e);
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
     *                      property="link",
     *                      type="string",
     *                      description="a button or link"
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
                'link' => 'nullable|string',
                'display_order' => 'bail|required|integer',
                'language_id' => 'bail|required|numeric|exists:languages,id',
                'images' => 'nullable|array',
                'images.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',
            ]);

            $content = Content::findOrFail($id);
            $content->update([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
                'landing_page_display' => $validatedData['landing_page_display'],
                'navbar_display' => $validatedData['navbar_display'],
                'link' => $validatedData['link'],
                'display_order' => $validatedData['display_order'],
                'language_id' => $validatedData['language_id'],
            ]);

            $this->imagesManagementService->updateImages($request, $content, 'content_id');

            return response()->json($content->load(['images', 'language']));
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('content', $e);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('content', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('content', $e);
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
            $this->imagesManagementService->deleteImages($content);
            $content->delete();
            return response()->json(['message' => 'content deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('content', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('content', $e);
        }
    }
}
