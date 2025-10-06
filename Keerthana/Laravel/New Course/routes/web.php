<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Postcontroller;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


    Route::get('/user/dashboard', function () {
        // $user = Auth::user();
        // if(Auth::check()){
        //     dd($user);
        // }

        return view('userDashboard');
    })->name('user.dashboard')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name(' ');
});


Route::get('/postindex', [Postcontroller::class, 'index'])->name('post.index');
Route::get('/postedit/{id}', [Postcontroller::class, 'edit'])->name('post.edit');
require __DIR__.'/auth.php';


Route::get('/fruits-list', function(){
    $fruits = array('banana','oranage', 'apple','pineapple','jackfruit','grapes');
    sort($fruits);
    return $fruits;
    // view('fruits');
});
