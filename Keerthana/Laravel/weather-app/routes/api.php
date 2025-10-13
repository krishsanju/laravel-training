<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\HistoryDataController;
use App\Http\Controllers\GeoLocationController;


Route::get('/get-temperature', [WeatherController::class,'getTemperature']);


Route::get('/pdf', [PdfController::class,'createPdf']);

Route::get('/history-data', [HistoryDataController::class, 'getHistoricalWeather']);

Route::get('/location-details', [GeoLocationController::class, 'locationDetails']);

