<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="register",
     *      tags={"User Register/Login"},
     *      summary="register the record",
     *      security= {{ "Bearer_auth": "" }},
     *      description="to register",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"name","email","phone","password"},
     *             @OA\Property(property="name", type="string", format="string", example="test5"),
     *             @OA\Property(property="email", type="string", format="string", example="test5@gmail.com"),
     *             @OA\Property(property="phone", type="string", format="string", example="9845345633"),
     *             @OA\Property(property="password", type="string", format="string", example="test5"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              description="success message",
     *              example={
     *                  "status_code"=200,
     *                  "message"="register has been created successfully.",
     *                  "payload"={}
     *              }
     *          )
     *       ),
     *    )
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => \Hash::make($request->password)
            ]);

            // $token = $user->createToken('Token')->accessToken;
            return response()->json(['message' => 'User registered successfully!', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => "Internal server error."], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"User Register/Login"},
     *      summary="login",
     *      security= {{ "Bearer_auth": "" }},
     *      description="to login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="string", example="xyz@gmail.com"),
     *             @OA\Property(property="password", type="string", format="string", example="xyz"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              description="success message",
     *              example={
     *                  "status_code"=200,
     *                  "message"="login has been created successfully.",
     *                  "payload"={}
     *              }
     *          )
     *       ),
     *    )
     */
    public function login(UserLoginRequest $request)
    {
        try {
            $response = Http::asForm()->post(config('app.passport_url') . '/oauth/token', [
                'grant_type' => 'password',
                'client_id' => config('app.passport_client_id'),
                'client_secret' => config('app.passport_client_secret'),
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/refresh-token",
     *     tags={"User Register/Login"},
     *     summary="refresh token",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Get refresh token",
     *     operationId="refreshToken",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             required={"refresh"},
     *             @OA\Property(property="refresh", type="string", format="string", example="..."),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     )
     * )
     */
    public function refreshToken(Request $request)
    {
        try {
            $response = Http::asForm()->post(config('app.passport_url') . '/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->refresh,
                'client_id' => config('app.passport_client_id'),
                'client_secret' => config('app.passport_client_secret'),
                'scope' => '',
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/get-user",
     *     tags={"User Actions"},
     *     summary="Get the user",
     *     security= {{ "Bearer_auth": "" }},
     *     description="Get the user",
     *     operationId="userInfo",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     )
     * )
     */
    public function userInfo()
    {
        try {
            $user = auth()->user();
            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
