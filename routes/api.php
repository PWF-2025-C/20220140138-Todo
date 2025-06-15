<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TodoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
// ->middleware('auth:sanctum');


Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
// });
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
     Route::get('/todos/search', [TodoController::class, 'search']);
    Route::apiResource('/todos', App\Http\Controllers\API\TodoController::class);
});

