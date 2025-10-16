<?php

namespace App\Models;

use App\Models\GeoLocation;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class HistoryData extends Model
{

    protected $fillable = [
        'city', 'date', 'temperature', 'precipitation'
    ];

    protected $casts = [
        'date' => 'date',
    ];


    public static function getOrCreateByCity($city){
        $geoLocation = new GeoLocation();
        $location = $geoLocation->where('name', $city)->first();
        if($location){ return $location;}
        
        $locationData = $geoLocation->urlResponse($city);
        return $geoLocation->create($locationData);
        
    }




    public static function historyParams($data, $location){
        return  [
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'daily' => $data['daily'],
            'timezone' => $location->timezone,
            'city' => $location->name, //extra param

        ];
    }

    public static function urlFilteredResponse($parameters){

        $response = Http::withoutVerifying()->get(config('services.apiUrls.history_url'), $parameters);


        if ($response->failed()) {
            $apiResponse=new ApiResponse;

            $apiResponse->setMessage('Failed to fetch weather data from API', false);

            throw new HttpResponseException(
                  $apiResponse->retrunResponse(500)
            );
        }

       $weatherData = array_map(function($date, $temp, $precipitation) {
            return [
                'date' => $date,
                'temperature' => $temp,
                'precipitation' => $precipitation
            ];
        }, $response['daily']['time'], $response['daily']['temperature_2m_mean'], $response['daily']['precipitation_sum']);

        $latitude = $response['latitude'];
        $longitude = $response['longitude'];
        $timezone = $response['timezone'];
        $city = $parameters['city'];

        self::storeWeatherData($city, $weatherData);


        $apiResponse=new ApiResponse;

        $apiResponse->setMessage('Weather data fetched successfully', true);
        $apiResponse->setData([
            'latitude'=> $latitude,
            'longitude'    => $longitude,
            'timezone'     => $timezone,
            'weatherData'  => $weatherData,
        ]);
       return  $apiResponse->retrunResponse(200);
    }


    public static function storeWeatherData(string $city, array $weatherData): void
    {
        self::insert(collect($weatherData)->map(function ($day) use ($city) {
            return [
                'city' => $city,
                'date' => $day['date'],
                'temperature' => $day['temperature'],
                'precipitation' => $day['precipitation'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all());


    }
}
