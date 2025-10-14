<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/session', function (Request $request) {
//STORE VALUE IN SESSION
    // $request->session()->put('name', 'keerthana');
    // request()->session()->put('name','keerthana');  //when $request instance is not there
    // session(['name' => 'keerthana']); //global helper function ***
    Session::put('name', 'keerthana'); //using facade ***

//RETRIEVE VALUE FROM SESSION    
    return $request->session()->get('name');  //retrieve value from session
    // return session('name'); //global helper function ***
    // return Session::get('name'); //using facade ***

//REMOVE VALUE FROM SESSION
    // $request->session()->forget('name', 'key2'); //remove single value from session
    // $request->session()->flush(); //remove all values from session
    // session()->forget('name'); //global helper function ***
    // session()->flush(); //global helper function ***    
    // Session::forget('name'); //using facade ***
    // Session::flush(); //using facade ***

});

Route::get('/cache', function (Request $request) {
//STORE VALUE IN CACHE
    // Cache::put('key', 'value', $seconds = 10); //store value in cache for 600 seconds
//RETRIEVE VALUE FROM CACHE
    return Cache::get('key'); //retrieve value from cache
});


//QUEUE
// Route::get('/send', function(){
//     $user = User::find(1);
//     info('web.php route hit');
//     dispatch(new SendWelcomeEmailJob($user));
//     // dd('Email Sent Successfully');
//     return true;
// });


//MODEL OBSERVER
// Route::resource('posts', PostController::class);
