<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('contact',ContactController::class);
Route::post('register',[AuthApiController::class,'register']);
Route::post('login',[AuthApiController::class,'login']);
Route::post('logout',[AuthApiController::class,'logout'])->middleware('auth:sanctum');//Don't Forget sanctum in logout//

Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('category',CategoryController::class);
    Route::apiResource('product',ProductController::class);
    Route::apiResource('stock',StockController::class);
});

