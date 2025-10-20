<?php

namespace App\Console\Commands;

use App\Models\HistoryData;
use App\Models\WeatherSummary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wether:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weather data every 5 mins and update database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            $parameters = [
                'city'       => 'Visakhapatnam',
                'latitude'   => 17.680090,
                'longitude'  => 83.201610,
                'start_date' => '2023-10-01',
                'end_date'   => '2024-10-16',
                'timezone'   => 'Asia/Kolkata',
                'daily'      => ['temperature_2m_mean', 'precipitation_sum'],
            ];
            
            $response = HistoryData::getResponse($parameters)->json();

            $weatherData = collect($response['daily']['time'])
                ->map(function ($date, $i) use ($response) {
                    return [
                        'date'          => $date,
                        'temperature'   => $response['daily']['temperature_2m_mean'][$i],
                        'precipitation' => $response['daily']['precipitation_sum'][$i],
                    ];
                });


            $monthlyData = WeatherSummary::groupByMonth($weatherData);

            WeatherSummary::updateMonthlySummary($monthlyData, $parameters);

            $this->info('Weather update command ran at ' . now());
        } catch (\Exception $e) {
            Log::error('Weather update failed: ' . $e->getMessage());
            $this->error('Failed to update weather data. Check logs for details.');
        }
    }


}
