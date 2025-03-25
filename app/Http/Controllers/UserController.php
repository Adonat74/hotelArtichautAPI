<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Services\ImagesManagementService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected ImagesManagementService $imagesManagementService;

    public function __construct(ImagesManagementService $imagesManagementService)
    {
        $this->imagesManagementService = $imagesManagementService;
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get one user by id- need to be authentified and role = user",
     *     tags={"Users"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the user",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getSingleUser(): JsonResponse
    {

        try {
            $user = Auth::user();

            $this->authorize('view', $user); // policy check

            return response()->json($user->load(['images']));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'user not found',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the user',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/user",
     *     summary="Update an existing user- need to be authentified and role = user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *               mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"email", "password", "firstname", "lastname", "address", "city", "postal_code", "phone", "is_pro"},
     *                  @OA\Property(property="email", type="string", format="email", description="User's email address"),
     *                  @OA\Property(property="password", type="string", description="User's password (minimum 10 characters)"),
     *                  @OA\Property(property="firstname", type="string", maxLength=50, description="User's first name"),
     *                  @OA\Property(property="lastname", type="string", maxLength=50, description="User's last name"),
     *                  @OA\Property(property="address", type="string", maxLength=100, description="User's address"),
     *                  @OA\Property(property="city", type="string", maxLength=100, description="User's city"),
     *                  @OA\Property(property="postal_code", type="string", description="User's postal code (5 digits)"),
     *                  @OA\Property(property="phone", type="string", description="User's phone number (10 digits)"),
     *                  @OA\Property(property="is_pro", type="boolean", description="Indicates te user status of pro or not"),
     *                  @OA\Property(property="image", type="string", format="binary")
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="User successfully updated"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateUser(Request $request): JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'email' => 'bail|required|email:rfc|unique:App\Models\User,email',
                'password' => 'bail|required|string|min:10',
                'firstname' => 'bail|required|string|max:50',
                'lastname' => 'bail|required|string|max:50',
                'address' => 'bail|required|string|max:100',
                'city' => 'bail|required|string|max:100',
                'postal_code' => 'bail|required|string|max:15',
                'phone' => 'bail|required|string|max:12',
                'is_pro' => 'bail|required|boolean',
                'image' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',// vérifie que les éléments sont des images
            ]);
            $user = Auth::user();
            $this->authorize('update', $user); // policy check

            $user->update([
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'address' => $validatedData['address'],
                'city' => $validatedData['city'],
                'postal_code' => $validatedData['postal_code'],
                'phone' => $validatedData['phone'],
                'is_pro' => $validatedData['is_pro'],
            ]);

            $this->imagesManagementService->updateSingleImage($request, $user, 'user_id');

            return response()->json($user->load(['images']));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e){
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e){
            return response()->json([
                'error' => 'An error occurred while updating the User',
                'details'=>    $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/user",
     *     summary="Delete a user by id- need to be authentified and role = user",
     *     tags={"Users"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the user",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteUser(): JsonResponse
    {
        try {
            $user = Auth::user();
            $this->authorize('delete', $user); // policy check

            $this->imagesManagementService->deleteSingleImage($user);

            $user->delete();

            return response()->json(['message' => 'user deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while deleting the user',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
