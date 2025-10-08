<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::get('/login', [AuthController::class,'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class,'loginFormSubmit'])->name('login.submit');

Route::get('/register', [AuthController::class,'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class,'registerFormSubmit'])->name('register.submit');

Route::get('/logout', [AuthController::class,'logout'])->name('logout');


// Route::middleware('authmiddleware')->group(function () {
    Route::get('/view-posts', [PostController::class,'adminPosts'])->name('posts.admin');

    Route::get('/view-user-post/{id}', [PostController::class, 'userPosts'])->name('posts.user');

    // Route::get('/post', [PostController::class,'create'])->name('post.create');
    Route::post('/post-submit', [PostController::class, 'store'])->name('post.submit');

    Route::get('/delete/{id}', [PostController::class,'delete'])->name('post.delete');

    Route::put('/post/update/{id}', [PostController::class, 'update'])->name('post.update');


// });
