<?php

namespace App\Http\Controllers;

use App\Models\GeoLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeoLocationController extends Controller
{
    public function locationDetails(Request $request){
        $city = $request->input('city');

        $result =  GeoLocation::urlResponse($city);

        return GeoLocation::storeLocationData($result);
        
        // $response = Http::withoutV
        // return response()->json([
        //     'latitude' => $locationData['latitude'],
        //     'longitude' => $locationData['longitude'],
        //     'name' => $locationData['name'],
        //     'country' => $locationData['country'],
        //     'admin1' => $locationData['admin1'] ?? null,
        //     'admin2' => $locationData['admin2'] ?? null,
        //      'timezone' => $locationData['timezone'] ?? null,
        // ]);
    }
}
