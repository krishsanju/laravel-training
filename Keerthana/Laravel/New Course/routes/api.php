<?php

use App\Models\User;
use App\Jobs\SendWelcomeEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


//QUEUE
Route::get('/send', function(){
    $user = User::find(1);
    dispatch(new SendWelcomeEmail($user));
});


//MODEL OBSERVER
// Route::resource('/posts', PostController::class);
Route::get('/posts', [PostController::class,'store'])->name('post.save');
