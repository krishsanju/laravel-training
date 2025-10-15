<?php

namespace App\Models;

use App\Http\Resources\GeolocationResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class GeoLocation extends Model
{

    protected $fillable = [
        'name', 'country', 'state', 'reference_location', 'latitude', 'longitude', 'timezone'
    ];

    protected $table = 'locations';

    public static function urlResponse($city){
        //in providers
        $response = Http::withoutVerifying()->get(config('services.apiUrls.geocoding_url'), [
            'name' => $city,
            'count' => 10,
        ]);


        if ($response->failed()) {
            throw new HttpResponseException(
                  ApiResponse::setMessage('Failed to fetch location data', false)->retrunResponse(500)
            );
        }

        if (empty($response['results'])) {
            throw new HttpResponseException(
                ApiResponse::setMessage('No results found for the specified city', false)->retrunResponse(404)
            ); 
        }
        //in providers

        $locationData = $response['results'][0];

        return new GeolocationResource($locationData);
    }

    public static function storeLocationData($locationData){
        $location = self::create([
                'name' => $locationData['name'],
                'country' => $locationData['country'],
                'state' => $locationData['admin1'] ?? null,
                'reference_location' => $locationData['admin2'] ?? null,
                'latitude' => $locationData['latitude'],
                'longitude' => $locationData['longitude'],
                'timezone' => $locationData['timezone'],
            ]);


            return ApiResponse::setMessage('Location stored successfully', true)->setData(['location' => $location])->retrunResponse(201); 
    }
}
