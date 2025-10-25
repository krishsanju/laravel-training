<?php

namespace App\Providers;

use App\Clients\ExchangeRateClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExchangeRateClient::class, fn() => new ExchangeRateClient());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    }
}
