<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::post('/login', [AuthController::class,'loginFormSubmit'])->name('login.submit');

Route::post('/register', [AuthController::class,'registerFormSubmit'])->name('register.submit');

Route::get('/logout', [AuthController::class,'logout'])->name('logout');


// Route::middleware('authmiddleware')->group(function () {
    Route::get('/view-posts', [PostController::class,'adminPosts'])->name('posts.admin');

    Route::get('/view-user-post/{id}', [PostController::class, 'userPosts'])->name('posts.user');

    // Route::get('/post', [PostController::class,'create'])->name('post.create');
    Route::post('/post-submit', [PostController::class, 'storePost'])->name('post.submit');

    Route::get('/delete/{id}', [PostController::class,'deletePost'])->name('post.delete');

    Route::put('/post/update/{id}', [PostController::class, 'updatePost'])->name('post.update');


// });
