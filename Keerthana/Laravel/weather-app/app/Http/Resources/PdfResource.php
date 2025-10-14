<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PdfResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'         => $this->name,
            'email'        => $this->email,
            'date'         => $this->date,
            'skills'       => $this->skills,
            'education'    => $this->education,
            'certificates' => $this->certificates,
            'projects'     => $this->projects,
            'hobbies'      => $this->hobbies,
            'experiences'  => $this->experiences,
        ];
    }
}
