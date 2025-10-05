<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', [ContactController::class,'index'])->name('contact.index');

Route::post('/contact', [ContactController::class,'contactsubmit'])->name('contact.submit');

Route::get('/fileUpload', [FileUploadController::class,'index'])->name('file.upload');

Route::post('/fileUpload', [FileUploadController::class,'filesubmit'])->name('file.submit');

Route::get('/fileDownload', [FileUploadController::class,'fileDownload'])->name('file.download');