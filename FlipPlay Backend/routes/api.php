<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('media', MediaController::class);
Route::get('/users/{user}/collection', [UserController::class, 'showCollection']);
Route::post('/users/{user}/collection', [UserController::class, 'addToCollection']);
Route::delete('/users/{user}/collection/{media}', [UserController::class, 'removeFromCollection']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
