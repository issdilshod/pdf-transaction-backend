<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Partners\CompanyController;
use App\Http\Controllers\Partners\CustomerController;
use App\Http\Controllers\Helpers\DescriptionController;
use App\Http\Controllers\Helpers\FontGroupController;
use App\Http\Controllers\Helpers\HolidayController;
use App\Http\Controllers\Partners\OrganizationController;
use App\Http\Controllers\Helpers\RangeController;
use App\Http\Controllers\Partners\SenderController;
use App\Http\Controllers\Helpers\StateController;
use App\Http\Controllers\Transactions\TransactionCategoryController;
use App\Http\Controllers\Transactions\TransactionPageController;
use App\Http\Controllers\Transactions\TransactionTypeController;
use App\Http\Controllers\Account\UserController;
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

    Route::resource('api/transaction-category', TransactionCategoryController::class);
});

Route::post('api/login', [AccountController::class, 'login']);