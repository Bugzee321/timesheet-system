<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\CreateRequest;
use App\Http\Requests\Attribute\UpdateRequest;
use App\Http\Resources\AttributeResource;
use App\Http\Responses\ApiResponse;
use App\Models\Attribute;
use App\Services\AttributesService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AttributeController extends Controller
{
    protected AttributesService $attributesService;

    public function __construct(AttributesService $attributesService)
    {
        $this->attributesService = $attributesService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/attributes",
     *     summary="Get list of attributes",
     *     security={{"passport": {}}},
     *     tags={"Attributes"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/AttributeResource")
     *     )
     * )
     *
     * Display a listing of the attributes.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $attributes = $this->attributesService->listAttributesPaginated();

            return ApiResponse::success([
                'attributes' => AttributeResource::collection($attributes),
                'meta' => [
                    'current_page' => $attributes->currentPage(),
                    'last_page' => $attributes->lastPage(),
                    'per_page' => $attributes->perPage(),
                    'total' => $attributes->total(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Error listing attributes: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while listing the attributes.', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/attributes",
     *     summary="Create a new attribute",
     *     tags={"Attributes"},
     *     security={{"passport": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AttributeCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Attribute created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/AttributeResource")
     *     )
     * )
     *
     * Store a newly created attribute in storage.
     *
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        try {
            $attribute = $this->attributesService->createAttribute($request->validated());

            return ApiResponse::success([
                'attribute' => new AttributeResource($attribute),
            ], 'Attribute created successfully', 201);
        } catch (Exception $e) {
            Log::error('Error creating attribute: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while creating the attribute.', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/attributes/{id}",
     *     summary="Get a specific attribute",
     *     tags={"Attributes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/AttributeResource")
     *     )
     * )
     *
     * Display the specified attribute.
     *
     * @param Attribute $attribute
     * @return JsonResponse
     */
    public function show(Attribute $attribute): JsonResponse
    {
        try {
            return ApiResponse::success([
                'attribute' => new AttributeResource($attribute),
            ]);
        } catch (Exception $e) {
            Log::error('Error showing attribute: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while showing the attribute.', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/attributes/{id}",
     *     summary="Update an existing attribute",
     *     security={{"passport": {}}},
     *     tags={"Attributes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AttributeUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attribute updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/AttributeResource")
     *     )
     * )
     *
     * Update the specified attribute in storage.
     *
     * @param UpdateRequest $request
     * @param Attribute $attribute
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Attribute $attribute): JsonResponse
    {
        try {
            $attribute = $this->attributesService->updateAttribute($attribute, $request->validated());

            return ApiResponse::success([
                'attribute' => new AttributeResource($attribute),
            ], 'Attribute updated successfully', 200);
        } catch (Exception $e) {
            Log::error('Error updating attribute: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while updating the attribute.', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/attributes/{id}",
     *     summary="Delete an attribute",
     *     security={{"passport": {}}},
     *     tags={"Attributes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attribute deleted successfully"
     *     )
     * )
     *
     * Remove the specified attribute from storage.
     *
     * @param Attribute $attribute
     * @return JsonResponse
     */
    public function destroy(Attribute $attribute): JsonResponse
    {
        try {
            $this->attributesService->deleteAttribute($attribute);

            return ApiResponse::success([], 'Attribute deleted successfully', 200);
        } catch (Exception $e) {
            Log::error('Error deleting attribute: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while deleting the attribute.', 500);
        }
    }
}
