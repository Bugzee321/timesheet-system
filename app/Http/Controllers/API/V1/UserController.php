<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Services\UsersService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UsersService $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="Display a listing of users",
     *     tags={"Users"},
     *     security={{"passport": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="users", type="array",
     *                     @OA\Items(ref="#/components/schemas/UserResource")
     *                 ),
     *                 @OA\Property(property="meta", type="object",
     *                     @OA\Property(property="current_page", type="integer", example=1),
     *                     @OA\Property(property="last_page", type="integer", example=10),
     *                     @OA\Property(property="per_page", type="integer", example=10),
     *                     @OA\Property(property="total", type="integer", example=100)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $users = $this->usersService->listUsersPaginated();

            return ApiResponse::success([
                'users' => UserResource::collection($users),
                'meta' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Error listing users: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while listing the users.', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Store a newly created user",
     *     tags={"Users"},
     *     security={{"passport": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     )
     * )
     */
    public function store(CreateRequest $request): JsonResponse
    {
        try {
            $user = $this->usersService->createUser($request->validated());

            return ApiResponse::success([
                'user' => new UserResource($user),
            ], 'User created successfully', 201);
        } catch (Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while creating the user.', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     summary="Display the specified user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     )
     * )
     */
    public function show(User $user): JsonResponse
    {
        try {
            return ApiResponse::success([
                'user' => new UserResource($user),
            ]);
        } catch (Exception $e) {
            Log::error('Error showing user: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while showing the user.', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/users/{id}",
     *     summary="Update the specified user",
     *     tags={"Users"},
     *     security={{"passport": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateRequest $request, User $user): JsonResponse
    {
        try {
            $user = $this->usersService->updateUser($user, $request->validated());

            return ApiResponse::success([
                'user' => new UserResource($user),
            ], 'User updated successfully', 200);
        } catch (Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while updating the user.', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     summary="Remove the specified user",
     *     tags={"Users"},
     *     security={{"passport": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User deleted successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $this->usersService->deleteUser($user);

            return ApiResponse::success([], 'User deleted successfully', 200);
        } catch (Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while deleting the user.', 500);
        }
    }
}
