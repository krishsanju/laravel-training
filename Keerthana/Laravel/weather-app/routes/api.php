<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SendPdfController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\GeoLocationController;
use App\Http\Controllers\HistoryDataController;

Route::get('test', function () {
    info('test url');
    return 'API is working';
});


Route::get('/get-temperature', [WeatherController::class,'getTemperature']);


Route::get('/pdf', [PdfController::class,'createPdf']);


Route::post('/send-pdf', [SendPdfController::class, 'sendMailWithPdf']);


Route::get('/history-data', [HistoryDataController::class, 'getHistoricalWeather']);

Route::get('/location-details', [GeoLocationController::class, 'locationDetails']);

