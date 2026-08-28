<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Public Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Sanctum Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Auth Users: Products
    Route::apiResource('products', ProductController::class);

    // Auth + Admin Only: Categories & Users
    Route::middleware('admin')->group(function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('users', UserController::class);
    });
});