<?php

use App\Http\Controllers\AuthController;
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
});

Route::get('/', function () {
    return view('dashboard');
});
