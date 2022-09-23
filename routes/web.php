<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('custom')->group(function() {
    Route::resource('api/user', UserController::class);

    Route::post('api/logout', [AccountController::class, 'logout']);
    Route::get('api/is_auth', [AccountController::class, 'is_auth']);

    Route::resource('api/sender', SenderController::class);
});

Route::post('api/login', [AccountController::class, 'login']);