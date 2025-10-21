<?php 

namespace App\Services;

use App\Models\Country;
use App\Clients\CountryClient;

class CountryService
{
    private CountryClient $countryClient;
    public function __construct(CountryClient $countryClient)
    {
        $this->countryClient = $countryClient;
    }

    public function fetchRelevantCountryInfoAndStore($countryName)
    {
        $countryInfo = $this->countryClient->fetchCountryInfo($countryName);
        if($countryInfo->status() == 404){
            abort(404, 'Country not found. Please check the country name ');
        }
        $country = Country::storeCountryData($countryInfo->json()[0]);

        return $country;
    }

    
}