<?php

namespace App\Http\Controllers;

use App\Models\HistoryData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\HistoryWeatherDataResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class HistoryDataController extends Controller
{
    
    public function getHistoricalWeather(Request $request)
    {        

        $data = $request->all();
        // $parameters = HistoryData::historyParams($data);

        // // $parameters = HistoryWeatherDataResource::collection($parameters);

        // $response = HistoryData::urlFilteredResponse($parameters);
        // return $response;


        $location = HistoryData::getOrCreateByCity($request->city);
        $parameters = HistoryData::historyParams($data, $location);


        // $response = Http::withoutVerifying()->get(config('services.apiUrls.history_url'), $parameters);

        // if ($response->failed()) {
        //     throw new HttpResponseException(response()->json([
        //         'message' => 'Failed to fetch weather data from API'
        //     ], 500));
        // }

        // $data = $response->json();
        // info($data);

        // // Store weather data (create raiyali )

        // return response()->json([
        //     'message' => 'Weather data stored successfully',
        //     'data' => $data
        // ]);

        
        return HistoryData::urlFilteredResponse($parameters );  //also store in database
    }
}
