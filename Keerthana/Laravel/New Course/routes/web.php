<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FileUploadController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', [ContactController::class,'index'])->name('contact.index');

Route::post('/contact', [ContactController::class,'contactsubmit'])->name('contact.submit');

Route::get('/fileUpload', [FileUploadController::class,'index'])->name('file.upload');

Route::post('/fileUpload', [FileUploadController::class,'filesubmit'])->name('file.submit');

Route::get('/fileDownload', [FileUploadController::class,'fileDownload'])->name('file.download');



//join Query Builder
Route::get('/innerjoin', function () {
    $userWithOrders = DB::table('users')
    ->join('orders', 'users.id', '=','orders.user_id')
    ->select('users.name', 'orders.product_name')->get();

    dd($userWithOrders);
});


Route::get('/leftjoin', function () {
    $userWithOrders = DB::table('users')
    ->leftjoin('orders', 'users.id', '=','orders.user_id')
    ->select('users.*', 'orders.product_name')->get();

    dd($userWithOrders);
});

Route::get('/rightjoin', function () {
    $userWithOrders = DB::table('orders')
    ->rightjoin('users', 'users.id', '=','orders.user_id')
    ->select('orders.product_name','users.name')->get();

    dd($userWithOrders);
});

Route::get('/fulljoin', function () {
    $userWithOrders = DB::table('users')
    ->leftJoin('orders', 'users.id', '=','orders.user_id')
    ->select('users.name', 'orders.product_name')
    ->union(
        DB::table('users')
        ->rightjoin('orders', 'users.id', '=','orders.user_id')
        ->select('users.name','orders.product_name')
    )->get();

    dd($userWithOrders);
});