<?php

use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


//QUEUE
Route::get('/send', function(){
    $user = User::find(1);
    dispatch(new SendWelcomeEmailJob($user));
    return true;
});


//MODEL OBSERVER
Route::resource('/posts', PostController::class);
