<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\FavoriteController;

Route::prefix('/auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);

    // Route::post('forgot-password', [AuthController::class, 'forgotPassword']); //
    // Route::post('reset-password', [AuthController::class, 'resetPassword']); //

    // Route::get('verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    //     ->name('verification.verify'); //
    // Route::post('resend-verification', [AuthController::class, 'resendVerification']); //
});


Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    // Route::delete('auth/delete', [AuthController::class, 'deleteAccount']); //
});


// Route::middleware(['auth:api', 'check.blocked'])->group(function () {
Route::middleware(['auth:api'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::get('/profile/activity', [ProfileController::class, 'activity']);
    Route::get('/all-favorites', [AdminController::class, 'getAllFavorites']);
    // Route::delete('/admin/users/{idToDelete}', [AdminController::class, 'destroy']);
});


Route::get('/books/search', [BookController::class, 'search']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books', [BookController::class, 'store']);



Route::middleware('auth:api')->group(function () {
    Route::post('/favorites', [FavoriteController::class, 'add']);
    Route::delete('/favorites', [FavoriteController::class, 'remove']);
    Route::get('/favorites', [FavoriteController::class, 'list']);
});
