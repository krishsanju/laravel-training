<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Clients\ExchangeRateClient;
use App\Http\Responses\ApiResponse;
use App\Http\Requests\ConvertCurrencyRequest;

class ExchangeRateController extends Controller
{
    protected $client;
    public function __construct(ExchangeRateClient $client)
    {
        $this->client = $client;
    }

    public function getRate(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $data = $this->client->getLiveRate($from, $to);

        if (!$data) {
            return ApiResponse::setMessage('Failed to fetch exchange rate.')
                ->response(Response::HTTP_BAD_GATEWAY);
        }

        return ApiResponse::setMessage('Live exchange rate fetched successfully.')
            ->mergeResults(['exchange_rate' => $data])
            ->response(Response::HTTP_OK);
    }

    public function convert(ConvertCurrencyRequest $request){
    $from   = $request->input('from');
    $to     = $request->input('to');
    $amount = $request->input('amount', 1.0);

    $data = $this->client->getLiveRate($from, $to, (float) $amount);

    if (!$data) {
        return ApiResponse::setMessage('Failed to perform currency conversion.')
                          ->response(Response::HTTP_BAD_GATEWAY);
    }

    return ApiResponse::setMessage('Currency conversion successful.')
                       ->mergeResults(['conversion' => $data])
                       ->response(Response::HTTP_OK);       
    }

}
