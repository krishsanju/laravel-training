<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class,'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class,'userDetails']);
});

Route::get('/logout', [UserController::class,'logout']);