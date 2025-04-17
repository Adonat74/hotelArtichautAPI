<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\ErrorsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
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
     *     path="/api/role/{id}",
     *     summary="Get one role by id- need to be authentified and role = master",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the role",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Role not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getSingleRole(int $id): JsonResponse
    {
        try {
            $role = Role::findOrFail($id);
            return response()->json($role);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('role', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('role', $e);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/role",
     *     summary="Get all roles- need to be authentified and role = master",
     *     tags={"Roles"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function getAllRoles(): JsonResponse
    {
        try {
            $roles = Role::all();
            return response()->json($roles);
        } catch (Exception $e) {
            return $this->errorsService->exception('role', $e);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/role",
     *     summary="Add a role- need to be authentified and role = master",
     *     tags={"Roles"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *                mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"role_name", "priority"},
     *                  @OA\Property(
     *                      property="role_name",
     *                      type="string",
     *                      description="The name of the role"
     *                  ),
     *                  @OA\Property(
     *                      property="priority",
     *                      type="integer",
     *                      description="The Content_models of the role"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Successful operation"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function addRole(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'role_name' => 'bail|required|string',
                'priority' => 'bail|required|numeric',
            ]);
            $role = new Role($validatedData);
            $role->save();

            return response()->json($role, 201);
        } catch (ValidationException $e) {
            return $this->errorsService->validationException('role', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('role', $e);
        }
    }



    /**
     * @OA\Post(
     *     path="/api/role/{id}",
     *     summary="Update a role by id- need to be authentified and role = master",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the role",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *                mediaType="multipart/form-data",
     *              @OA\Schema(
     *                   required={"role_name", "priority"},
     *                   @OA\Property(
     *                       property="role_name",
     *                       type="string",
     *                       description="The name of the role"
     *                   ),
     *                   @OA\Property(
     *                       property="priority",
     *                       type="integer",
     *                       description="The Content_models of the role"
     *                   ),
     *               )
     *          )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Role not found"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function updateRole(Request $request, string $id): JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'role_name' => 'bail|required|string',
                'priority' => 'bail|required|numeric',
            ]);
            $role = Role::findOrFail($id);
            $role->update($validatedData);

            return response()->json($role);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('role', $e);
        } catch (ValidationException $e){
            return $this->errorsService->validationException('role', $e);
        } catch (Exception $e){
            return $this->errorsService->exception('role', $e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/role/{id}",
     *     summary="Delete a role by id- need to be authentified and role = master",
     *     tags={"Roles"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="The ID of the role",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Role not found"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */
    public function deleteRole(string $id): JsonResponse
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json(['message' => 'role deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return $this->errorsService->modelNotFoundException('role', $e);
        } catch (Exception $e) {
            return $this->errorsService->exception('role', $e);
        }
    }
}
