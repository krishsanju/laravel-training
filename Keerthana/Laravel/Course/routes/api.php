<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;

Route::get("/", function () {
    info("adsf ");
    return view("welcome");
});
Route::resource('/posts', PostController::class);

