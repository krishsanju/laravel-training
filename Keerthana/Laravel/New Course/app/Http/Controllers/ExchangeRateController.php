<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Clients\ExchangeRateClient;
use App\Http\Responses\ApiResponse;
use App\Models\FavouriteConversion;
use App\Actions\GetQuarterlyExchangeRates;
use App\Http\Requests\ConvertCurrencyRequest;
use App\Http\Requests\HistoricalRatesRequest;
use App\Http\Requests\SaveFavouriteConversionRequest;

use App\Facades\ExchangeRateFacade as ExchangeRate;

class ExchangeRateController extends Controller
{
    protected ExchangeRateClient $client;
    protected User $userModel;
    protected FavouriteConversion $favouriteConversion;
    public function __construct(ExchangeRateClient $client, User $userModel, FavouriteConversion $favouriteConversion)
    {
        $this->client = $client;
        $this->userModel = $userModel;
        $this->favouriteConversion = $favouriteConversion;
    }

    public function getRate(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        // $data = $this->client->getLiveRate($from, $to);
        $data = ExchangeRate::getLiveRate($from, $to);

        if (!$data) {
            return ApiResponse::setMessage('Failed to fetch exchange rate.')
                ->response(Response::HTTP_BAD_GATEWAY);
        }

        return ApiResponse::setMessage('Live exchange rate fetched successfully.')
            ->mergeResults(['results' => ['query' => $data['query'], 'result' => $data['result']]])
            ->response(Response::HTTP_OK);
    }

    public function convert(ConvertCurrencyRequest $request){
        $from   = $request->input('from');
        $to     = $request->input('to');
        $amount = $request->input('amount', 1.0);

        // $data = $this->client->getLiveRate($from, $to, (float) $amount);
        $data = ExchangeRate::getLiveRate($from, $to, (float) $amount);

        if (!$data) {
            return ApiResponse::setMessage('Failed to perform currency conversion.')
                            ->response(Response::HTTP_BAD_GATEWAY);
        }

        return ApiResponse::setMessage('Currency conversion successful.')
                        ->mergeResults(["results" => ['query' => $data['query'], 'result' => $data['result']]])
                        ->response(Response::HTTP_OK);       
    }


    public function saveFavourite(SaveFavouriteConversionRequest  $request)
    {

        $user = $this->userModel->whereId($request->input('user_id'))->first();
        $favourite = $this->favouriteConversion->saveConvertion($user, $request);

        return ApiResponse::setMessage('Favourite conversion saved successfully.')
                          ->mergeResults(['favourite' => $favourite])
                          ->response(Response::HTTP_OK);
    }


    public function getHistoricalRates(HistoricalRatesRequest $request)
    {
        $source      = strtoupper($request->input('source', 'USD'));
        $currencies  = strtoupper($request->input('currencies')); // e.g. INR,GBP
        $startDate   = Carbon::parse($request->input('start_date'));
        $endDate     = Carbon::parse($request->input('end_date'));

        $result = GetQuarterlyExchangeRates::run($source, $currencies, $startDate, $endDate);

        if($result['status'] == false)
        {
            return $result;
        }

        return ApiResponse::setMessage('Quarterly exchange rate averages fetched successfully.')
                    ->mergeResults($result)
                    ->response(Response::HTTP_OK);
    }

    

}
