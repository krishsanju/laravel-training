<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/LOGGEDIN', function(){
    return "LOGGEDIN";
});

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('logout', [GoogleController::class, 'logout'])->name('logout');
