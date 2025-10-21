<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;

Route::get('/get-country-info', [CountryController::class, 'showCountryInfo']);