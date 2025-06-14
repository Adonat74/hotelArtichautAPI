<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserRequest;
use App\Models\User;
use App\Services\CompareUserRoleService;
use App\Services\ErrorsService;
use App\Services\ImagesManagementService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminUserController extends Controller
{
    protected ImagesManagementService $imagesManagementService;
    protected CompareUserRoleService $compareUserRoleService;
    protected ErrorsService $errorsService;


    public function __construct(
        ImagesManagementService $imagesManagementService,
        CompareUserRoleService $compareUserRoleService,
        ErrorsService $errorsService

    )
    {
        $this->imagesManagementService = $imagesManagementService;
        $this->compareUserRoleService = $compareUserRoleService;
        $this->errorsService = $errorsService;
    }

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
            $users = User::with(['images'])->get();
            return response()->json($users);
        } catch (Exception $e) {
            return $this->errorsService->exception('user', $e);
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
            $user = User::with(['images'])->findOrFail($id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('user', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('user', $e);
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
     *                  @OA\Property(property="image", type="string", format="binary")
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="User successfully created"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addUser(AdminUserRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            //Check user role, so it can't create/update/delete a user with bigger role
            $this->compareUserRoleService->compareUserRole(Auth::user(), $validatedData['role_id']);

            $user = new User($request->safe()->except(['image']));
            $user->save();

            $this->imagesManagementService->addSingleImage($request, $user, 'user_id');

            return response()->json($user->load(['images']), 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('user', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('user', $e);
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
    public function updateUser(AdminUserRequest $request, string $id): JsonResponse
    {
        try{
            $user = User::findOrFail($id);

            $validatedData = $request->validate([
//                permet de rendre l'email unique sauf pour le précédent email
                'email' => ['bail', 'required', 'email:rfc', Rule::unique('users', 'email')->ignore($user->id),
                ],
                'password' => 'bail|required|string|min:10',
                'firstname' => 'bail|required|string|max:50',
                'lastname' => 'bail|required|string|max:50',
                'address' => 'bail|required|string|max:70',
                'city' => 'bail|required|string|max:30',
                'postal_code' => 'bail|required|string|max:15',
                'phone' => 'bail|required|string|max:12',
                'role_id' => 'bail|required|integer|exists:App\Models\Role,id',
                'is_pro' => 'bail|required|boolean',
                'is_vip' => 'bail|required|boolean',
                'image' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',// vérifie que les éléments sont des images
            ]);


            // Check user role, so it can't create/update/delete a user with bigger role
            $this->compareUserRoleService->compareUserRole(Auth::user(), $user->role->id);
            $this->compareUserRoleService->compareUserRole(Auth::user(), $validatedData['role_id']);

            $user->update($request->safe()->except(['image']));

            $this->imagesManagementService->updateSingleImage($request, $user, 'user_id');

            return response()->json($user->load(['images']));
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('user', $e);
        } catch (ValidationException $e){
            return $this->errorsService->validationException('user', $e);
        } catch (Exception $e){
            return $this->errorsService->exception('user', $e);
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

            //Check user role, so it can't create/update/delete a user with bigger role
            $this->compareUserRoleService->compareUserRole(Auth::user(), $user->role->id);

            $this->imagesManagementService->deleteSingleImage($user);
            $user->delete();

            return response()->json(['message' => 'user deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('user', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('user', $e);
        }
    }
}
