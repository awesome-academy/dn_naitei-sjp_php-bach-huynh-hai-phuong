<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login'])
    ->name('api.logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout'])
        ->name('api.logout');
    Route::get('profile', [AuthController::class, 'profile'])
        ->name('api.profile')->middleware('role:trainee');

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/{course}', [CourseController::class, 'show']);
    });

    Route::prefix('tasks/{task}/reports')->group(function () {
        Route::post('/', [ReportController::class, 'store']);
        Route::get('/', [ReportController::class, 'index']);
    });

    Route::post('subjects/{courseSubject}/finish', [ReportController::class, 'finishCourseSubject']);
});
