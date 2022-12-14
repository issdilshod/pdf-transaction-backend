<?php

use App\Http\Controllers\Partners\CustomerController;
use App\Http\Controllers\Helpers\DescriptionController;
use App\Http\Controllers\Helpers\FontGroupController;
use App\Http\Controllers\Helpers\HolidayController;
use App\Http\Controllers\Partners\OrganizationController;
use App\Http\Controllers\Helpers\RangeController;
use App\Http\Controllers\Partners\SenderController;
use App\Http\Controllers\Partners\CompanyController;
use App\Http\Controllers\Transactions\TransactionCategoryController;
use App\Http\Controllers\Transactions\TransactionPageController;
use App\Http\Controllers\Transactions\TransactionTypeController;
use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Helpers\PdfImageController;
use App\Http\Controllers\Helpers\PdfTemplateController;
use App\Http\Controllers\Statements\StatementController;
use Illuminate\Support\Facades\Route;

Route::get('api/user', [UserController::class, 'index']);
Route::post('api/user', [UserController::class, 'store']);
Route::get('api/user/{id}', [UserController::class, 'show']);
Route::put('api/user/{id}', [UserController::class, 'update']);
Route::delete('api/user/{id}', [UserController::class, 'destroy']);

Route::get('api/sender', [SenderController::class, 'index']);
Route::post('api/sender', [SenderController::class, 'store']);
Route::get('api/sender/{id}', [SenderController::class, 'show']);
Route::put('api/sender/{id}', [SenderController::class, 'update']);
Route::delete('api/sender/{id}', [SenderController::class, 'destroy']);

Route::get('api/customer', [CustomerController::class, 'index']);
Route::post('api/customer', [CustomerController::class, 'store']);
Route::get('api/customer/{id}', [CustomerController::class, 'show']);
Route::put('api/customer/{id}', [CustomerController::class, 'update']);
Route::delete('api/customer/{id}', [CustomerController::class, 'destroy']);

Route::get('api/company', [CompanyController::class, 'index']);
Route::post('api/company', [CompanyController::class, 'store']);
Route::get('api/company/{id}', [CompanyController::class, 'show']);
Route::put('api/company/{id}', [CompanyController::class, 'update']);
Route::delete('api/company/{id}', [CompanyController::class, 'destroy']);

Route::get('api/organization', [OrganizationController::class, 'index']);
Route::post('api/organization', [OrganizationController::class, 'store']);
Route::get('api/organization/{id}', [OrganizationController::class, 'show']);
Route::put('api/organization/{id}', [OrganizationController::class, 'update']);
Route::delete('api/organization/{id}', [OrganizationController::class, 'destroy']);

Route::get('api/transaction-type', [TransactionTypeController::class, 'index']);
Route::post('api/transaction-type', [TransactionTypeController::class, 'store']);
Route::get('api/transaction-type/{id}', [TransactionTypeController::class, 'show']);
Route::put('api/transaction-type/{id}', [TransactionTypeController::class, 'update']);
Route::delete('api/transaction-type/{id}', [TransactionTypeController::class, 'destroy']);

Route::get('api/range', [RangeController::class, 'index']);
Route::post('api/range', [RangeController::class, 'store']);
Route::get('api/range/{id}', [RangeController::class, 'show']);
Route::put('api/range/{id}', [RangeController::class, 'update']);
Route::delete('api/range/{id}', [RangeController::class, 'destroy']);

Route::get('api/holiday', [HolidayController::class, 'index']);
Route::post('api/holiday', [HolidayController::class, 'store']);
Route::get('api/holiday/{id}', [HolidayController::class, 'show']);
Route::put('api/holiday/{id}', [HolidayController::class, 'update']);
Route::delete('api/holiday/{id}', [HolidayController::class, 'destroy']);

Route::get('api/transaction-page', [TransactionPageController::class, 'index']);
Route::post('api/transaction-page', [TransactionPageController::class, 'store']);
Route::get('api/transaction-page/{id}', [TransactionPageController::class, 'show']);
Route::put('api/transaction-page/{id}', [TransactionPageController::class, 'update']);
Route::delete('api/transaction-page/{id}', [TransactionPageController::class, 'destroy']);

Route::get('api/font-group', [FontGroupController::class, 'index']);
Route::post('api/font-group', [FontGroupController::class, 'store']);
Route::get('api/font-group/{id}', [FontGroupController::class, 'show']);
Route::put('api/font-group/{id}', [FontGroupController::class, 'update']);
Route::delete('api/font-group/{id}', [FontGroupController::class, 'destroy']);

Route::get('api/description', [DescriptionController::class, 'index']);
Route::post('api/description', [DescriptionController::class, 'store']);
Route::get('api/description/{id}', [DescriptionController::class, 'show']);
Route::put('api/description/{id}', [DescriptionController::class, 'update']);
Route::delete('api/description/{id}', [DescriptionController::class, 'destroy']);

Route::get('api/transaction-category', [TransactionCategoryController::class, 'index']);
Route::post('api/transaction-category', [TransactionCategoryController::class, 'store']);
Route::get('api/transaction-category/{id}', [TransactionCategoryController::class, 'show']);
Route::put('api/transaction-category/{id}', [TransactionCategoryController::class, 'update']);
Route::delete('api/transaction-category/{id}', [TransactionCategoryController::class, 'destroy']);

Route::get('api/statement', [StatementController::class, 'index']);
Route::post('api/statement', [StatementController::class, 'store']);
Route::get('api/statement/{id}', [StatementController::class, 'show']);
Route::put('api/statement/{id}', [StatementController::class, 'update']);
Route::delete('api/statement/{id}', [StatementController::class, 'destroy']);

Route::get('api/pdf-image', [PdfImageController::class, 'index']);
Route::post('api/pdf-image', [PdfImageController::class, 'store']);
Route::get('api/pdf-image/{id}', [PdfImageController::class, 'show']);
Route::put('api/pdf-image/{id}', [PdfImageController::class, 'update']);
Route::delete('api/pdf-image/{id}', [PdfImageController::class, 'destroy']);

Route::get('api/pdf-template', [PdfTemplateController::class, 'index']);
Route::post('api/pdf-template', [PdfTemplateController::class, 'store']);
Route::get('api/pdf-template/{id}', [PdfTemplateController::class, 'show']);
Route::put('api/pdf-template/{id}', [PdfTemplateController::class, 'update']);
Route::delete('api/pdf-template/{id}', [PdfTemplateController::class, 'destroy']);