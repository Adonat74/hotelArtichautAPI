<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminUserController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/admin/user",
     *     summary="Get all users- need to be authentified and role = employee",
     *     tags={"AdminUsers"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllUsers(): JsonResponse
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching the users',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/admin/user/{id}",
     *     summary="Get one user by id- need to be authentified and role = employee",
     *     tags={"AdminUsers"},
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
    public function getSingleUser(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
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
     *     path="/api/admin/user",
     *     summary="add a new user- need to be authentified and role = manager",
     *     tags={"AdminUsers"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *               mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"email", "password", "firstname", "lastname", "address", "city", "postal_code", "phone", "role_id", "is_pro", "is_vip"},
     *                  @OA\Property(property="email", type="string", format="email", description="User's email address"),
     *                  @OA\Property(property="password", type="string", description="User's password (minimum 10 characters)"),
     *                  @OA\Property(property="firstname", type="string", maxLength=50, description="User's first name"),
     *                  @OA\Property(property="lastname", type="string", maxLength=50, description="User's last name"),
     *                  @OA\Property(property="address", type="string", maxLength=100, description="User's address"),
     *                  @OA\Property(property="city", type="string", maxLength=100, description="User's city"),
     *                  @OA\Property(property="postal_code", type="string", description="User's postal code (5 digits)"),
     *                  @OA\Property(property="phone", type="string", description="User's phone number (10 digits)"),
     *                  @OA\Property(property="role_id", type="integer", description="User's role"),
     *                  @OA\Property(property="is_pro", type="boolean", description="User's status (optional)"),
     *                  @OA\Property(property="is_vip", type="boolean", description="Indicates if the user is VIP"),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="User successfully created"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addUser(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'email' => 'bail|required|email:rfc|unique:App\Models\User,email',
                'password' => 'bail|required|string|min:10',
                'firstname' => 'bail|required|string|max:50',
                'lastname' => 'bail|required|string|max:50',
                'address' => 'bail|required|string|max:100',
                'city' => 'bail|required|string|max:100',
                'postal_code' => 'bail|required|string|max:15',
                'phone' => 'bail|required|string|max:12',
                'role_id' => 'bail|required|integer|exists:App\Models\Role,id',
                'is_pro' => 'bail|required|boolean',
                'is_vip' => 'bail|required|boolean',
            ]);
            $user = new User($validatedData);
            $user->save();

            return response()->json($user, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while adding the user',
                'message'=>    $e->getMessage(),
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/admin/user/{id}",
     *     summary="Update an existing user- need to be authentified and role = manager",
     *     tags={"AdminUsers"},
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
     *                  required={"email", "password", "firstname", "lastname", "address", "city", "postal_code", "phone", "role_id", "is_pro", "is_vip"},
     *                  @OA\Property(property="email", type="string", format="email", description="User's email address"),
     *                  @OA\Property(property="password", type="string", description="User's password (minimum 10 characters)"),
     *                  @OA\Property(property="firstname", type="string", maxLength=50, description="User's first name"),
     *                  @OA\Property(property="lastname", type="string", maxLength=50, description="User's last name"),
     *                  @OA\Property(property="address", type="string", maxLength=100, description="User's address"),
     *                  @OA\Property(property="city", type="string", maxLength=100, description="User's city"),
     *                  @OA\Property(property="postal_code", type="string", description="User's postal code (5 digits)"),
     *                  @OA\Property(property="phone", type="string", description="User's phone number (10 digits)"),
     *                  @OA\Property(property="role_id", type="integer", description="User's role"),
     *                  @OA\Property(property="is_pro", type="boolean", description="User's status (optional)"),
     *                  @OA\Property(property="is_vip", type="boolean", description="Indicates if the user is VIP"),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="User successfully updated"),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateUser(Request $request, string $id): JsonResponse
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
                'role_id' => 'bail|required|integer|exists:App\Models\Role,id',
                'is_pro' => 'bail|required|boolean',
                'is_vip' => 'bail|required|boolean',
            ]);
            $user = User::findOrFail($id);
            $user->update($validatedData);

            return response()->json($user);
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
     *     path="/api/admin/user/{id}",
     *     summary="Delete a user by id- need to be authentified and role = manager",
     *     tags={"AdminUsers"},
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
    public function deleteUser(string $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
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
