<?php

namespace App\Http\Controllers;

use App\Models\GeoLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeoLocationController extends Controller
{
    public function locationDetails(Request $request){
        $city = strtolower($request->input('city')); //validation for city not done

        $geolocation = new GeoLocation();
        $result =  $geolocation->urlResponse($city);
        return $geolocation->storeLocationData($result);

    }
}
