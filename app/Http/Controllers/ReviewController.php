<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\ErrorsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class ReviewController extends Controller
{

    protected ErrorsService $errorsService;

    public function __construct(
        ErrorsService $errorsService
    )
    {
        $this->errorsService = $errorsService;
    }

    /**
     * @OA\Get(
     *     path="/api/review/{id}",
     *     summary="Get one review by id - need to be authentified",
     *     tags={"Reviews"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the review",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Review not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getSingleReview(int $id): JsonResponse
    {
        try {
            $review = Review::findOrFail($id);

            $this->authorize('view', $review); //policy to authorize only owner

            return response()->json($review);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('review', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('review', $e);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/review",
     *     summary="Get all reviews",
     *     tags={"Reviews"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllReviews(): JsonResponse
    {
        try {
            $reviews = Review::all();
            return response()->json($reviews);
        } catch (Exception $e) {
            return $this->errorsService->exception('review', $e);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/review/user",
     *     summary="Get all user reviews - need to be authentified",
     *     tags={"Reviews"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllUserReviews(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $reviews = Review::where('user_id', $user->id)->get();

            return response()->json($reviews);
        } catch (Exception $e) {
            return $this->errorsService->exception('review', $e);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/review",
     *     summary="Add a review  - need to be authentified",
     *     tags={"Reviews"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *                mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"rate", "review_content", "display_order"},
     *                  @OA\Property(
     *                      property="rate",
     *                      type="number",
     *                      description="The rating of the review, between 1 and 5"
     *                  ),
     *                  @OA\Property(
     *                      property="review_content",
     *                      type="string",
     *                      description="The Content_models of the review"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addReview(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'rate' => 'bail|required|numeric|min:1|max:5',
                'review_content' => 'bail|required|string',
                'display_order' => 'nullable|integer',
            ]);

            $user = $request->user();

            $review = new Review($validatedData);
            $review->user_id = $user->id;
            $review->save();

            return response()->json($review, 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('review', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('review', $e);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/review/{id}",
     *     summary="Update a review by id - need to be authentified",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the review",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *                mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"rate", "review_content", "display_order"},
     *                  @OA\Property(
     *                      property="rate",
     *                      type="number",
     *                      description="The rating of the review, between 1 and 5"
     *                  ),
     *                  @OA\Property(
     *                      property="review_content",
     *                      type="string",
     *                      description="The Content_models of the review"
     *                  ),
     *                   @OA\Property(
     *                       property="display_order",
     *                       type="integer",
     *                       description="The desired disaly order the items should be"
     *                   ),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Review not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateReview(Request $request, string $id): JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'rate' => 'bail|required|numeric|min:1|max:5',
                'review_content' => 'bail|required|string',
                'display_order' => 'nullable|integer',
            ]);
            $review = Review::findOrFail($id);

            $this->authorize('update', $review); //policy to authorize only owner

            $review->update($validatedData);

            return response()->json($review);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('review', $e);
        } catch (ValidationException $e){
            return $this->errorsService->validationException('review', $e);
        } catch (Exception $e){
            return $this->errorsService->exception('review', $e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/review/{id}",
     *     summary="Delete a review by id - need to be authentified",
     *     tags={"Reviews"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the review",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Review not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteReview(string $id): JsonResponse
    {
        try {
            $review = Review::findOrFail($id);

            $this->authorize('delete', $review); //policy to authorize only owner

            $review->delete();

            return response()->json(['message' => 'review deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('review', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('review', $e);
        }
    }
}
