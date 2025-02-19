<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Responses\ApiResponse;
use App\Models\Project;
use App\Services\ProjectsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    protected ProjectsService $projectsService;

    public function __construct(ProjectsService $projectsService)
    {
        $this->projectsService = $projectsService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/projects",
     *     summary="Display a listing of projects",
     *     tags={"Projects"},
     *     security={{"passport": {}}},
     *     @OA\Parameter(
     *         name="filters",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="array", @OA\Items(type="string")),
     *         description="Optional filters for project listing"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="projects", type="array",
     *                     @OA\Items(ref="#/components/schemas/ProjectResource")
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
     * 
     * Display a listing of projects.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $filters = request()->query('filters', []);
            $projects = $this->projectsService->listProjectsPaginated($filters);

            return ApiResponse::success([
                'projects' => ProjectResource::collection($projects),
                'meta' => [
                    'current_page' => $projects->currentPage(),
                    'last_page' => $projects->lastPage(),
                    'per_page' => $projects->perPage(),
                    'total' => $projects->total(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Error listing projects: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while listing the projects.', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/projects",
     *     summary="Store a newly created project",
     *     tags={"Projects"},
     *     security={{"passport": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Project created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="project", ref="#/components/schemas/ProjectResource")
     *             )
     *         )
     *     )
     * )
     * 
     * Store a newly created project in storage.
     *
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        try {
            $project = $this->projectsService->createProject($request->validated());

            return ApiResponse::success(
                ['project' => new ProjectResource($project)],
                'Project created successfully',
                201
            );
        } catch (Exception $e) {
            Log::error('Error creating project: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while creating the project.', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/projects/{id}",
     *     summary="Display the specified project",
     *     tags={"Projects"},
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
     *                 @OA\Property(property="project", ref="#/components/schemas/ProjectResource")
     *             )
     *         )
     *     )
     * )
     * 
     * Display the specified project.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        try {
            return ApiResponse::success(['project' => new ProjectResource($project)]);
        } catch (Exception $e) {
            Log::error('Error showing project: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while showing the project.', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/projects/{id}",
     *     summary="Update the specified project",
     *     tags={"Projects"},
     *     security={{"passport": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Project updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="project", ref="#/components/schemas/ProjectResource")
     *             )
     *         )
     *     )
     * )
     * 
     * Update the specified project in storage.
     *
     * @param UpdateRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Project $project): JsonResponse
    {
        try {
            $project = $this->projectsService->updateProject($project, $request->validated());

            return ApiResponse::success(
                ['project' => new ProjectResource($project)],
                'Project updated successfully',
                200
            );
        } catch (Exception $e) {
            Log::error('Error updating project: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while updating the project.', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/projects/{id}",
     *     summary="Remove the specified project",
     *     security={{"passport": {}}},
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Project deleted successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     * 
     * Remove the specified project from storage.
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        try {
            $this->projectsService->deleteProject($project);

            return ApiResponse::success([], 'Project deleted successfully', 200);
        } catch (Exception $e) {
            Log::error('Error deleting project: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while deleting the project.', 500);
        }
    }
}
