<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Responses\ApiResponse;

class WeatherDataClient
{
    public function fetchWeatherData(array $params): array
    {
        $response = Http::withoutVerifying()->get(config('services.apiUrls.history_url'), $params);

        if ($response->failed()) {
            $apiResponse=new ApiResponse;
            $apiResponse->setMessage('Failed to fetch weather data from API', false);
            throw new HttpResponseException(
                  $apiResponse->retrunResponse(500)
            );
        }

        return $response->json();
    }
}
