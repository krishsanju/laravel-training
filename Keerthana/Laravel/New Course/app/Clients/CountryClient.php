<?php 

namespace App\Clients;

use Illuminate\Support\Facades\Http;

class CountryClient
{
    public function __construct()
    {

    }

    public function fetchCountryInfo($countryName)
    {
        try{
            $response = Http::withoutVerifying()->get(config('services.endPoints.restCountries').'/name/'. $countryName);
            // if($response->status() == 404){
            //     return response()->json(['message' => 'Country not found'],404);
            // }
            return $response;
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Could not fetch country data.'], 500);
        }

    }


}