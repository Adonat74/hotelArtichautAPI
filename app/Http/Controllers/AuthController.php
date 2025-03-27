<?php

namespace App\Http\Controllers;

use App\Mail\QrCodeMail;
use App\Mail\RegisterMail;
use App\Models\Image;
use App\Models\User;
use App\Services\ImagesManagementService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected ImagesManagementService $imagesManagementService;

    public function __construct(ImagesManagementService $imagesManagementService)
    {
        $this->imagesManagementService = $imagesManagementService;
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *               mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"email", "password"},
     *                  @OA\Property(property="email", type="string", format="email", description="User's email address"),
     *                  @OA\Property(property="password", type="string", description="User's password"),
     *              )
     *          )
     *     ),
     *     @OA\Response(response=200, description="User successfully login"),
     *     @OA\Response(response=401, description="Credentials mismatch"),
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        $user->token_version += 1;
        $user->save();
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user->load(['images']),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *               mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"email", "password", "firstname", "lastname", "address", "city", "postal_code", "phone"},
     *                  @OA\Property(property="email", type="string", format="email", description="User's email address"),
     *                  @OA\Property(property="password", type="string", description="User's password (minimum 10 characters)"),
     *                  @OA\Property(property="firstname", type="string", maxLength=50, description="User's first name"),
     *                  @OA\Property(property="lastname", type="string", maxLength=50, description="User's last name"),
     *                  @OA\Property(property="address", type="string", maxLength=100, description="User's address"),
     *                  @OA\Property(property="city", type="string", maxLength=100, description="User's city"),
     *                  @OA\Property(property="postal_code", type="string", description="User's postal code (5 digits)"),
     *                  @OA\Property(property="phone", type="string", description="User's phone number (10 digits)"),
     *                  @OA\Property(property="is_pro", type="integer", description="User's status (optional) 1 or 2 default false(0)"),
     *                  @OA\Property(property="image", type="string", format="binary")
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="User successfully created"),
     *     @OA\Response(response=422, description="Validation failed"),
     *     @OA\Response(response=500, description="An error occurred")
     * )
     */

    public function register(Request $request): JsonResponse
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
                'is_pro' => 'bail|required|boolean',
                'image' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,image/jpeg,image/png,image/jpg,image/gif|max:100000',// vérifie que les éléments sont des images
            ]);
            $user = new User([
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
            $user->save();

            $this->imagesManagementService->addSingleImage($request, $user, 'user_id');



//            Mail::to($user->email)->send(new RegisterMail($user));
            Mail::to('donatgoninet.antoine@gmail.com')->send(new RegisterMail($user));

            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials);
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user->load(['images']),
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
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
     *     path="/api/logout",
     *     summary="Logout - need to be authentified and role = user",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="User successfully logout"),
     * )
     */
    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }



    /**
     * @OA\Get(
     *     path="/api/refresh",
     *     summary="refresh the token- need to be authentified and role = user",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="User fetched"),
     * )
     */
    public function refresh(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
