<?php

namespace App\Services;

use App\Clients\GeoLocationClient;
use App\Models\GeoLocation;

class GeoLocationService
{
    protected GeoLocationClient $geoClient;
    protected GeoLocation $geoLocation;


    public function __construct(GeoLocationClient $geoClient, GeoLocation $geoLocation)
    {
        $this->geoClient = $geoClient;
        $this->geoLocation = $geoLocation;
    }


    public function getOrCreateLocationByCity(string $city)
    {
    
        $city = strtolower($city);
        $location = $this->geoLocation::where('name', $city)->first();

        if ($location) {
            return $location;
        }

        $locationData = $this->geoClient->fetchCityData($city);

        return $this->geoLocation::updateOrCreate(
            ['name' => $city],
            [
                'country' => $locationData['country'],
                'state' => $locationData['admin1'] ?? null,
                'reference_location' => $locationData['admin2'] ?? null,
                'latitude' => $locationData['latitude'],
                'longitude' => $locationData['longitude'],
                'timezone' => $locationData['timezone'],
            ]
        );
    }
}
