<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherSummary extends Model
{
    protected $fillable = [
        'city', 'year', 'month', 'temperature_sum', 'precipitation_sum'
    ];

    public static function groupByMonth($weatherData)
    {
        return $weatherData
            ->groupBy(fn($item) => date('Y-m', strtotime($item['date'])))
            ->map(fn($group) => [
                'temperature_sum'   => $group->sum('temperature'),
                'precipitation_sum' => $group->sum('precipitation'),
            ]);
    }

    public static function updateMonthlySummary($monthlyData, $parameters)
    {
        $monthlyData->each(function ($values, $key) use ($parameters) {
            [$year, $month] = explode('-', $key);

            WeatherSummary::updateOrCreate(
                ['city' => $parameters['city'], 'year' => $year, 'month' => $month],
                [
                    'temperature_sum'   => $values['temperature_sum'],
                    'precipitation_sum' => $values['precipitation_sum'],
                ]
            );
        });
    }
}
