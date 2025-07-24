<?php

use Illuminate\Support\Facades\Route;

Route::get('/sign-in', function () {
    return view('auth.sign-in');
});
