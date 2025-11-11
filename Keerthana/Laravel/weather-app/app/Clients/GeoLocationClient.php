<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Responses\ApiResponse;

class GeoLocationClient
{
    public function fetchCityData(string $city): array
    {
        $response = Http::withoutVerifying()->get(config('services.apiUrls.geocoding_url'), [
            'name' => $city,
            'count' => 1,
        ]);

        if ($response->failed()) {
            $apiResponse=new ApiResponse;
            $apiResponse->setMessage('Failed to fetch location data', false);
            throw new HttpResponseException(
                  $apiResponse->retrunResponse(500)
            );
        }
        $results = $response->json('results', []);

        if (empty($results)) {
            $apiResponse=new ApiResponse;
            $apiResponse->setMessage('No results found for the specified city', false);
            throw new HttpResponseException(
                  $apiResponse->retrunResponse(404)
            );
        }

        return $results[0];
    }
}
