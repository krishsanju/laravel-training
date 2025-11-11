<?php

namespace App\Http\Resources;

use App\Enums\WeatherUnits;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lat' => $request->latitude,
            'lon' => $request->longitude,
            'units' => WeatherUnits::fromKey($request->units)->description,
            'appid' => config('services.openweather.key'),
    
        ];

        
    }
}
