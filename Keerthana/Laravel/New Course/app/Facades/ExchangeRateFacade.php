<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ExchangeRateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'exchange-rate-client';
    }
}