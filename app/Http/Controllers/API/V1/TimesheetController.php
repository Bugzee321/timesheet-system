<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\CreateRequest;
use App\Http\Requests\Timesheet\UpdateRequest;
use App\Http\Responses\ApiResponse;
use App\Http\Resources\TimesheetResource;
use App\Models\Timesheet;
use App\Services\TimesheetsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TimesheetController extends Controller
{
    protected TimesheetsService $timesheetsService;

    public function __construct(TimesheetsService $timesheetsService)
    {
        $this->timesheetsService = $timesheetsService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/timesheets",
     *     summary="Display a listing of timesheets",
     *     tags={"Timesheets"},
     *     security={{"passport": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="timesheets", type="array",
     *                     @OA\Items(ref="#/components/schemas/TimesheetResource")
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
     * Display a listing of timesheets.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $timesheets = $this->timesheetsService->listTimesheetsPaginated();
            return ApiResponse::success([
                'timesheets' => TimesheetResource::collection($timesheets),
                'meta' => [
                    'current_page' => $timesheets->currentPage(),
                    'last_page' => $timesheets->lastPage(),
                    'per_page' => $timesheets->perPage(),
                    'total' => $timesheets->total(),
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Error listing timesheets: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while listing the timesheets.', 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/timesheets",
     *     summary="Store a newly created timesheet",
     *     tags={"Timesheets"},
     *     security={{"passport": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TimesheetCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Timesheet created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Timesheet created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="timesheet", ref="#/components/schemas/TimesheetResource")
     *             )
     *         )
     *     )
     * )
     * 
     * Store a newly created timesheet.
     *
     * @param  \App\Http\Requests\Timesheet\CreateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        try {
            $timesheet = $this->timesheetsService->createTimesheet($request->validated());
            return ApiResponse::success([
                'timesheet' => new TimesheetResource($timesheet),
            ], 'Timesheet created successfully', 201);
        } catch (Exception $e) {
            Log::error('Error creating timesheet: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while creating the timesheet.', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/timesheets/{id}",
     *     summary="Display the specified timesheet",
     *     tags={"Timesheets"},
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
     *                 @OA\Property(property="timesheet", ref="#/components/schemas/TimesheetResource")
     *             )
     *         )
     *     )
     * )
     * 
     * Display the specified timesheet.
     *
     * @param  \App\Models\Timesheet  $timesheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Timesheet $timesheet): JsonResponse
    {
        try {
            return ApiResponse::success([
                'timesheet' => new TimesheetResource($timesheet),
            ]);
        } catch (Exception $e) {
            Log::error('Error showing timesheet: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while showing the timesheet.', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/timesheets/{id}",
     *     summary="Update the specified timesheet",
     *     tags={"Timesheets"},
     *     security={{"passport": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TimesheetUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Timesheet updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Timesheet updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="timesheet", ref="#/components/schemas/TimesheetResource")
     *             )
     *         )
     *     )
     * )
     * 
     * Update the specified timesheet.
     *
     * @param  \App\Http\Requests\Timesheet\UpdateRequest  $request
     * @param  \App\Models\Timesheet  $timesheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Timesheet $timesheet): JsonResponse
    {
        try {
            $timesheet = $this->timesheetsService->updateTimesheet($timesheet, $request->validated());
            return ApiResponse::success([
                'timesheet' => new TimesheetResource($timesheet),
            ], 'Timesheet updated successfully', 200);
        } catch (Exception $e) {
            Log::error('Error updating timesheet: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while updating the timesheet.', 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/timesheets/{id}",
     *     summary="Remove the specified timesheet",
     *     tags={"Timesheets"},
     *     security={{"passport": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Timesheet deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Timesheet deleted successfully"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     * 
     * Remove the specified timesheet.
     *
     * @param  \App\Models\Timesheet  $timesheet
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Timesheet $timesheet): JsonResponse
    {
        try {
            $this->timesheetsService->deleteTimesheet($timesheet);
            return ApiResponse::success([], 'Timesheet deleted successfully', 200);
        } catch (Exception $e) {
            Log::error('Error deleting timesheet: ' . $e->getMessage());
            return ApiResponse::error('An error occurred while deleting the timesheet.', 500);
        }
    }
}
