<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\{
    AttributeController,
    AuthController,
    ProjectController,
    TimesheetController,
    UserController
};

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware(['auth:api', 'throttle:10,1'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('timesheets', TimesheetController::class);
        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('attributes', AttributeController::class);
        Route::apiResource('users', UserController::class);
    });
});
