<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class GeoLocation extends Model
{

    protected $fillable = [
        'name', 'country', 'admin1', 'admin2', 'latitude', 'longitude', 'timezone'
    ];

    protected $table = 'locations';

    public static function urlResponse($city){
        $response = Http::withoutVerifying()->get(config('services.apiUrls.geocoding_url'), [
            'name' => $city,
            'count' => 10,
        ]);


        if ($response->failed()) {
            throw new HttpResponseException(
                response()->json(['message' => 'Failed to fetch location data'], 500)
            );
        }

        if (empty($response['results'])) {
            throw new HttpResponseException(
                response()->json(['message' => 'No results found for the specified city'], 404)
            );
            
        }

        $locationData = $response['results'][0];

        // return $locationData;
        return [
            'latitude' => $locationData['latitude'],
            'longitude' => $locationData['longitude'],
            'name' => $locationData['name'],
            'country' => $locationData['country'],
            'admin1' => $locationData['admin1'] ?? null,
            'admin2' => $locationData['admin2'] ?? null,
             'timezone' => $locationData['timezone'] ?? null,
        ];
    }

    public static function storeLocationData($locationData){
        $location = self::create([
                'name' => $locationData['name'],
                'country' => $locationData['country'],
                'admin1' => $locationData['admin1'] ?? null,
                'admin2' => $locationData['admin2'] ?? null,
                'latitude' => $locationData['latitude'],
                'longitude' => $locationData['longitude'],
                'timezone' => $locationData['timezone'],
            ]);

            return response()->json([
                'message' => 'Location stored successfully',
                'data' => $location
            ]);
    }
}
