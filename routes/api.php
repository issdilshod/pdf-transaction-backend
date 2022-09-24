<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\UserController;
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

Route::get('api/organization', [OrganizationController::class, 'index']);
Route::post('api/organization', [OrganizationController::class, 'store']);
Route::get('api/organization/{id}', [OrganizationController::class, 'show']);
Route::put('api/organization/{id}', [OrganizationController::class, 'update']);
Route::delete('api/organization/{id}', [OrganizationController::class, 'destroy']);