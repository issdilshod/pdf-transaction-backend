<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DescriptionController;
use App\Http\Controllers\FontGroupController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RangeController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TransactionPageController;
use App\Http\Controllers\TransactionTypeController;
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

    Route::resource('api/transaction-type', TransactionTypeController::class);

    Route::resource('api/range', RangeController::class);

    Route::resource('api/holiday', HolidayController::class);

    Route::resource('api/transaction-page', TransactionPageController::class);

    Route::resource('api/font-group', FontGroupController::class);

    Route::resource('api/description', DescriptionController::class);
});

Route::post('api/login', [AccountController::class, 'login']);