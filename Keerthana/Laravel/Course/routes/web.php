<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\PostController;
use App\Models\User;
use Carbon\Carbon;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');


//DATES
    Route::get('/date',function(){
        $date = new DateTime();

        echo $date->format('d M, Y');
        echo '<br>';
        echo Carbon::now()->format('d M, Y');
        echo '<br>';
        echo Carbon::now()->addDays(10)->diffForHumans();
        echo '<br>';
        echo Carbon::now()->subMonths(10)->diffForHumans();
        echo '<br>';
        echo Carbon::now()->yesterday();
    });

//Forms


    Route::resource('/posts', PostController::class);


    Route::get('/getname',function(){  //accessors
        $user = User::find(1);
        echo $user->name;
    });

    Route::get('/setname',function(){  //mutators
        $user = User::find(1);
        $user->name = 'neethika kandipalli';
        $user->save();
    });
