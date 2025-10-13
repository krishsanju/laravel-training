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
        // return  [
        //     'latitude' => $this->input('latitude'),
        //     'longitude' => $this->input('longitude'),
        //     'start_date' => $this->input('start_date'),
        //     'end_date' => $this->input('end_date'),
        //     'daily' => $this->input('daily'),
        //     'timezone' => $this->input('timezone'),
        // ];

        return [   ];
    }

}
