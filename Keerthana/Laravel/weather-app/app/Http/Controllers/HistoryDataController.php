<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\HistoryData;
use Illuminate\Http\Request;
use App\Services\GeoLocationService;
use App\Services\WeatherDataService;
use App\Http\Requests\HistoryDataRequest;
use App\Http\Resources\HistoryWeatherDataResource;

class HistoryDataController extends Controller
{
    
    // public function getHistoricalWeather(HistoryDataRequest $request)
    // {        
    //     $data = $request->all();

    //     $historyData = new HistoryData();
    //     $location = $historyData->getOrCreateByCity(strtolower($request->city));
    //     $parameters = $historyData->historyParams($data, $location);
    //     // $parameters = (new HistoryWeatherDataResource($data, $location))->toArray(request());
        
    //     return HistoryData::urlFilteredResponse($parameters );  //also store in database
    // }


    protected GeoLocationService $geoLocationService;
    protected WeatherDataService $weatherDataService;

    public function __construct(GeoLocationService $geoLocationService, WeatherDataService $weatherDataService)
    {
        $this->geoLocationService = $geoLocationService;
        $this->weatherDataService = $weatherDataService;
    }

    public function getHistoricalWeather(HistoryDataRequest $request)
    {
        $data = $request->validated();

        //getting location details 
        $location = $this->geoLocationService->getOrCreateLocationByCity(strtolower($data['city']));

        //preparing parameters for weather data api
        $params = $this->weatherDataService->historyParams($data, $location);

        //fetching and storing weather data
        $weatherData = $this->weatherDataService->fetchAndStoreWeather($params, $data['city']);

        $apiResponse = new ApiResponse();
        $apiResponse->setMessage('Historical weather data retrieved successfully.');
        $apiResponse->setData($weatherData);
        return $apiResponse->retrunResponse();
    }
}
