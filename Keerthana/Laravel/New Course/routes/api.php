<?php

use App\Http\Controllers\GnewsTopController;
use Illuminate\Support\Facades\Route;

Route::get('/news', [GnewsTopController::class,'fetchNews'])->name('');