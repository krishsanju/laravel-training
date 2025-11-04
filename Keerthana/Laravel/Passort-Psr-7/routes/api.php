<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
});

// Protected test route
Route::get('profile', function (Illuminate\Http\Request $request) {
    return $request->user();
})->middleware('auth:api');