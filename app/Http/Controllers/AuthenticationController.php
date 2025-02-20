<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
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
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Response([
                'message' => 'Successful login!'
            ], 200);
        }

        return Response([
            'message' => 'Mismatch email and password!'
        ], 401);
    }



    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout",
     *     tags={"Authentication"},
     *     @OA\Response(response=200, description="User successfully logout"),
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out!',
        ]);
    }
}
