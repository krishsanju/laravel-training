<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return Inertia::render('welcome');
    // return "hai";
})->name('home');



// Route::resource('/posts', PostController::class);

