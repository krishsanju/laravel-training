<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\FavoriteController;

Route::prefix('/auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);

    Route::post('forgot-password', [AuthController::class, 'forgotPassword']); //
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    // Route::post('reset-password', [AuthController::class, 'resetPassword']); //

    // Route::get('verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    //     ->name('verification.verify'); //
    // Route::post('resend-verification', [AuthController::class, 'resendVerification']); //
});


Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    // Route::delete('auth/delete', [AuthController::class, 'deleteAccount']); //
});


//
Route::middleware(['auth:api', 'not_blocked'])->group(function () {
    // Route::middleware(['auth:api'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
    Route::get('/profile/activity', [ProfileController::class, 'activity']);
});

//ADMIN ROUTES
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::get('/all-favorites', [AdminController::class, 'getAllFavorites']);
    // Route::delete('/admin/users/{idToDelete}', [AdminController::class, 'destroy']);
    Route::get('/view-activity', [AdminController::class, 'activity']);
    Route::delete('/remove-review-by-admin', [AdminController::class, 'remove']);
    Route::put('/block-user', [AdminController::class, 'blockUser']);
    Route::get('/reports/users-favorites-csv', [AdminController::class, 'exportUsersFavoritesCsv']);
    Route::get('/reports/monthly-favorites/pdf', [AdminController::class, 'monthlyFavoritesPdf']);
});


//BOOKS
Route::middleware(['throttle:book-search'])->get('/books/search', [BookController::class, 'search']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books', [BookController::class, 'store']);


//FAVORITES
Route::middleware(['auth:api'])->group(function () {
    Route::post('/add-favorites', [FavoriteController::class, 'add']);
    Route::delete('/remove-favorites', [FavoriteController::class, 'remove']);
    Route::get('/view-favorites', [FavoriteController::class, 'list']);
});

//REVIEWS
Route::middleware(['auth:api'])->group(function () {
    Route::post('/add-review', [ReviewController::class, 'add']);
    Route::delete('/remove-review', [ReviewController::class, 'remove']);
    // Route::get('/view-review', [ReviewController::class, 'list']);
});

Route::get('/test-info', function () {

    // $arr = array('1' => 'foo');
    // info($arr);

    // $obj = (object) array('1' => 'foo');
    // $objJson = json_encode($obj);
    // info($objJson);


    info("Hello");
    info(123);
    info('hai this is msg', [1, 2, 3]);
    info(array(
        'A' => 1,
        'C' => 2,
        'H' => 3,
    ));
    info('hai this is msg',(object)['x' => 1]); //error
    // info(json_encode((object)['x' => 1]));
});
