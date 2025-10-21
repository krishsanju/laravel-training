<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\CountryService;

class CountryController extends Controller
{
    protected $countryService;
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }
    public function showCountryInfo(Request $request)
    {
        $countryName = $request->country_name;
        $countryInfo = Country::whereCountry($countryName)->first();

        if (!$countryInfo) {
            $countryInfo = $this->countryService->fetchRelevantCountryInfoAndStore($countryName);
        }

        return response()->json($countryInfo);
    }
}
