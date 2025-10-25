<?php

use App\Clients\ExchangeRateClient;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRateController;

Route::prefix('rates')->group(function () {
    Route::get('/', [ExchangeRateController::class, 'getRate']);
    // Route::get('/base', [ExchangeRateController::class, 'getRatesByBase']);
    Route::get('/convert', [ExchangeRateController::class, 'convert']);
});