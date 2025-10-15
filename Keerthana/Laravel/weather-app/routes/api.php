<?php

use App\Mail\SendResumeMail;
use App\Events\SendResumeMailEvent;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\GeoLocationController;
use App\Http\Controllers\HistoryDataController;

Route::get('test', function () {
    info('test url');
    return 'API is working';
});


Route::get('/get-temperature', [WeatherController::class,'getTemperature']);


Route::get('/pdf', [PdfController::class,'createPdf']);
Route::get('/send-pdf/{email}', function ($email){

    // $publiFiles = Storage::disk('public')->files();
    // info($publiFiles);

    // if (empty($publiFiles)) {
    //     return ApiResponse::setMessage('No files found in the public storage.')->retrunResponse(404);
    // }

    // $firstpdf = $publiFiles;
    // event(new SendResumeMailEvent($email, $firstpdf));
    // return  ApiResponse::setMessage('Mail sent successfully')->retrunResponse(200);

    // $files = Storage::disk('public/dfs')->files('public');
    // dd($files);

    $files = Storage::files('public');
    dd($files);



});

Route::get('/history-data', [HistoryDataController::class, 'getHistoricalWeather']);

Route::get('/location-details', [GeoLocationController::class, 'locationDetails']);

