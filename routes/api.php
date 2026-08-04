<?php

use App\Http\Controllers\API\V1\{AuthController, CategoryController, MediaController, TagController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResource('media', MediaController::class);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('tag', TagController::class);
});
