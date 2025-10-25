<?php

namespace App\Clients;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ExchangeRateClient
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.currency_exchange.api_base_url');
        $this->apiKey = config('services.currency_exchange.api_key');
    }
 
    public function getLiveRate(string $from, string $to, float $amount = 1.0)
    {
        try
        {
            $response = Http::withoutVerifying()->get("{$this->baseUrl}/convert", [
                'from' => strtoupper($from),
                'to'   => strtoupper($to),
                'amount' => $amount,
                'access_key' => $this->apiKey,
            ]);
    
            if ($response->failed()) {
                throw new \Exception('API request failed');
            }
    
            return $response->json();
        } catch (\Exception $e) {
        Log::error('Currency conversion failed', ['error' => $e->getMessage()]);
        return null;
    }
    }


}