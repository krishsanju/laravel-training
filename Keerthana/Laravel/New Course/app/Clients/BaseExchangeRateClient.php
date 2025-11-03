<?php

namespace App\Clients;

class BaseExchangeRateClient
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.currency_exchange.api_base_url');
        $this->apiKey = config('services.currency_exchange.api_key');
    }

    
}