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
// Route::get('/send-pdf/{email}', function ($email){

//     $files = File::files(storage_path('app\public\Pdfs'));
//     if (empty($files)) {
//         return ApiResponse::setMessage('No files found in the public storage.')->retrunResponse(404);
//     }
//     $firstPdf = $files[0]->getRealPath();


//     event(new SendResumeMailEvent($email, $firstPdf));

//     return ApiResponse::setMessage('Mail sent successfully to '.$email)->retrunResponse(200);

// });

Route::post('/send-pdf', [SendPdfController::class, 'sendMailWithPdf']);


Route::get('/history-data', [HistoryDataController::class, 'getHistoricalWeather']);

Route::get('/location-details', [GeoLocationController::class, 'locationDetails']);

