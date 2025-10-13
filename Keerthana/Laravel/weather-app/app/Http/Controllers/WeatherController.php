<?php

namespace App\Http\Controllers;

use App\Enums\WeatherUnits;
use App\Http\Resources\WeatherResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class WeatherController extends Controller
{
    public function getTemperature(Request $request){
        $apiKey = config('services.openweather.key');
        $apiUrls = config('services.openweather.url');
        $units  = $request->input('unit');

        // $data = [
        //         'lat' => $request->input('latitude'),
        //         'lon' => $request->input('longitude'),
        //         'appid' => $apiKey,
        //         'units' => WeatherUnits::fromKey($request->input('units'))->description,
        //     ];

        $data =  new WeatherResource($request->all());

        // $corredinates = getLatitudeLongitude();
        info('------------------------------');
        info($data);
        info('------------------------------');

        Response::make(json_encode($data));
        $response = Http::withoutVerifying()->get($apiUrls,  (array) $data);

        $data = $response->json();

        return response()->json([
            'location' => $data['name'] ?? 'Unknown',
            'temperature' => $data['main']['temp'] ?? null,
        ]);
    }
}
