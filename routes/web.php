<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('custom')->group(function() {
    Route::resource('api/user', UserController::class);

    Route::post('api/logout', [AccountController::class, 'logout']);
    Route::get('api/is_auth', [AccountController::class, 'is_auth']);

    Route::resource('api/sender', SenderController::class);
    Route::get('api/sender/search/{search}', [SenderController::class, 'search']);

    Route::resource('api/customer', CustomerController::class);
    Route::get('api/customer/search/{search}', [CustomerController::class, 'search']);

    Route::get('api/state', [StateController::class, 'index']);

    Route::resource('api/company', CompanyController::class);
    Route::get('api/company/search/{search}', [CompanyController::class, 'search']);

    Route::resource('api/organization', OrganizationController::class);
});

Route::post('api/login', [AccountController::class, 'login']);