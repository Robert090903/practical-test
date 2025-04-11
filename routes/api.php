<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryController::class);

// Remove the duplicate import
// use App\Http\Controllers\ProductController;

Route::apiResource('products', ProductController::class);
