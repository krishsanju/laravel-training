<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryWeatherDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'latitude' => $this->location->latitude,
            'longitude' => $this->location->longitude,
            'start_date' => $this['start_date'],
            'end_date' => $this['end_date'],
            'daily' => $this['daily'],
            'timezone' => $this->location->timezone,
            'city' => $this->location->name,
        ];
    }

}
