<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'country', 'independent', 'currencies', 'capital', 'region', 'languages', 
        'borders', 'flag', 'population', 'timezones'
    ] ;

    protected $table = "countries";

    public static function storeCountryData($countryData)
    {
        $country = self::updateOrCreate(
            ['country' => $countryData['name']['common']], // Search by country name
            [
                'independent' => $countryData['independent'],
                'currencies' => implode(', ', array_column($countryData['currencies'], 'name')),
                'capital' => implode(', ', $countryData['capital']),
                'region' => $countryData['region'],
                'languages' => implode(', ', $countryData['languages']),
                'borders' => implode(', ', $countryData['borders']),
                'flag' => $countryData['flag'],
                'population' => $countryData['population'],
                'timezones' => implode(', ', $countryData['timezones'])
            ]
        );

        return $country;
    }
}
