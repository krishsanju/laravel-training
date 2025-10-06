<?php

use App\Http\Controllers\PostController;
use App\Http\Middleware\CheckRoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//NORMAL MIDDLEWARE
    Route::get('/post', [PostController::class,'index'])->name('post.index');
    Route::post('/post', [PostController::class,'handlePost'])->name('post.handle')
            ->middleware(CheckRoleMiddleware::class);
    //// ROUTE GROUP
        // Route::group(['middleware'=> CheckRoleMiddleware::class], function () {
        //     Route::post('/post', [PostController::class,'handlePost'])->name('post.handle');
        // });

// //GLOBAL MIDDLEWARE
//     Route::get('/post', [PostController::class,'index'])->name('post.index');
//     Route::post('/post', [PostController::class,'handlePost'])->name('post.handle'); //middle ware is given in postController


// //GROUP MIDDLEWARE
//     Route::get('/post', [PostController::class,'index'])->name('post.index')->middleware('groupMiddleware');
//     Route::post('/post', [PostController::class,'handlePost'])->name('post.handle')->middleware('groupMiddleware')

//MIDDLE PARAMETERS

    Route::get('follower/dashboard', function () {
        return 'follower dashboard';
    })->middleware('checkrole:follower');

    Route::get('influencer/dashboard', function () {
        dd('influencer dashboard');
    })->middleware('checkrole:influencer');


