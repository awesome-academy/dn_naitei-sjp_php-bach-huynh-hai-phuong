<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login'])
    ->name('api.logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout'])
        ->name('api.logout');
    Route::get('profile', [AuthController::class, 'profile'])
        ->name('api.profile')->middleware('role:trainee');
});
