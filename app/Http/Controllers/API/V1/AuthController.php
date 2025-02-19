<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Responses\ApiResponse;
use App\Services\AuthenticationService;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthController extends Controller
{
    protected UsersService $usersService;
    protected AuthenticationService $authenticationService;

    public function __construct(UsersService $usersService, AuthenticationService $authenticationService)
    {
        $this->usersService = $usersService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * Register a new user and return an access token.
     *
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterUserRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = $this->usersService->createUser($request->validated());
            $token = $this->authenticationService->createToken($user);

            return ApiResponse::success(
                ['token' => $token],
                'User registered successfully',
                201
            );
        } catch (Exception $e) {
            Log::error('Error registering user: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while registering the user.', 500);
        }
    }

    /**
     * Authenticate a user and return an access token.
     *
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Login a user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginUserRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User logged in successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            if (!$this->authenticationService->login($request->only('email', 'password'))) {
                return ApiResponse::error('Unauthorized', 401);
            }

            $user = $this->usersService->getUserByEmail($request->email);
            $token = $this->authenticationService->createToken($user);

            return ApiResponse::success(
                ['token' => $token],
                'User logged in successfully',
                200
            );
        } catch (Exception $e) {
            Log::error('Error logging in user: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while logging in the user.', 500);
        }
    }

    /**
     * Logout a user by revoking their access token.
     *
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="Logout a user",
     *     tags={"Auth"},
     *     security={{"passport": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Logged out successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authenticationService->logout();

            return ApiResponse::success([], 'Logged out successfully', 200);
        } catch (Exception $e) {
            Log::error('Error logging out user: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while logging out the user.', 500);
        }
    }
}
