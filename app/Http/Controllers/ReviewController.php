<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class ReviewController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/review/{id}",
     *     summary="Get one review by id",
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
            return response()->json($review);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'review not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the review',
                'message' => $e->getMessage()
            ], 500);
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
            return response()->json([
                'error' => 'An error occurred while fetching the reviews',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/review",
     *     summary="Add a review",
     *     tags={"Reviews"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *                mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"rate", "review_content", "display_order", "user_id"},
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
     *                  @OA\Property(
     *                      property="display_order",
     *                      type="integer",
     *                      description="The desired disaly order the items should be"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer",
     *                      description="The ID of the user who created the review"
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
                'display_order' => 'bail|required|integer',
                'user_id' => 'bail|required|numeric',
            ]);
            $review = new Review($validatedData);
            $review->save();

            return response()->json($review, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
                ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the review',
                'message'=>    $e->getMessage(),
            ], 500);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/review/{id}",
     *     summary="Update a review by id",
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
     *                  required={"rate", "review_content", "display_order", "user_id"},
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
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer",
     *                      description="The ID of the user who created the review"
     *                  ),
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
                'display_order' => 'bail|required|integer',
                'user_id' => 'bail|required|numeric',
            ]);
            $review = Review::findOrFail($id);
            $review->update($validatedData);

            return response()->json($review);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Review not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e){
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e){
            return response()->json([
                'error' => 'An error occurred while updating the Review',
                'details'=>    $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/review/{id}",
     *     summary="Delete a review by id",
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
            $review->delete();

            return response()->json(['message' => 'review deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Review not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the review',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
