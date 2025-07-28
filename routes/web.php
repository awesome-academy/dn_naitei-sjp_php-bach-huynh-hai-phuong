<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(callback: function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])
        ->name('login.form');

    Route::post('login', [AuthController::class, 'login'])
        ->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])
            ->name('index');

        Route::get('create', [CourseController::class, 'create'])
            ->name('create');

        Route::post('store', [CourseController::class, 'store'])
            ->name('store');

        Route::get('{course}', [CourseController::class, 'show'])
            ->name('show');

        Route::get('{course}/edit', [CourseController::class, 'edit'])
            ->name('edit');

        Route::put('{course}', [CourseController::class, 'update'])
            ->name('update');

        Route::delete('{course}', [CourseController::class, 'destroy'])
            ->name('destroy');
    });
});
