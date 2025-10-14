<?php

namespace App\Http\Controllers;

use App\Models\HistoryData;
use Illuminate\Http\Request;
use App\Http\Requests\HistoryDataRequest;
use App\Http\Resources\HistoryWeatherDataResource;

class HistoryDataController extends Controller
{
    
    public function getHistoricalWeather(HistoryDataRequest $request)
    {        
        $data = $request->all();

        $historyData = new HistoryData();
        $location = $historyData->getOrCreateByCity(strtolower($request->city));
        $parameters = $historyData->historyParams($data, $location);
        // $parameters = (new HistoryWeatherDataResource($data, $location))->toArray(request());
        
        return HistoryData::urlFilteredResponse($parameters );  //also store in database
    }
}
