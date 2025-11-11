<?php

namespace App\Services;

use App\Clients\WeatherDataClient;
use App\Models\HistoryData;

class WeatherDataService
{
    protected WeatherDataClient $weatherClient;

    public function __construct(WeatherDataClient $weatherClient)
    {
        $this->weatherClient = $weatherClient;
    }


    public function historyParams(array $data, $location): array
    {
        return [
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'daily' => 'temperature_2m_mean,precipitation_sum',
            'timezone' => $location->timezone,
        ];
    }


    public function fetchAndStoreWeather(array $params, string $city): array
    {
        $weatherResponse = $this->weatherClient->fetchWeatherData($params);

        if (!isset($weatherResponse['daily'])) {
            throw new \Exception('Weather data response missing "daily" key');
        }

        $weatherData = array_map(function($date, $temp, $precipitation)use ($city) {
            return [
                'city' => $city,
                'date' => $date,
                'temperature' => $temp,
                'precipitation' => $precipitation
            ];
        }, $weatherResponse['daily']['time'], $weatherResponse['daily']['temperature_2m_mean'], $weatherResponse['daily']['precipitation_sum']);


        // HistoryData::updateOrCreate(
        //     ['city' => $city, 'date' => $weatherData['date']],
        //     $weatherData
        // );

        // HistoryData::upsert(
        //     $weatherData,
        //     ['city', 'date'],
        //     ['temperature', 'precipitation'] ,
        // );

        foreach ($weatherData as $data) {
            HistoryData::updateOrCreate(
                ['city' => $data['city'], 'date' => $data['date']],
                $data
            );
        }

        return $weatherData;
    }
}
