<?php

namespace App\Providers;

use App\Models\GeoLocation;
use App\Clients\GeoLocationClient;
use App\Clients\WeatherDataClient;
use App\Services\GeoLocationService;
use App\Services\WeatherDataService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Clients
        $this->app->singleton(GeoLocationClient::class, fn() => new GeoLocationClient());
        $this->app->singleton(WeatherDataClient::class, fn() => new WeatherDataClient());

        // Services
        $this->app->singleton(GeoLocationService::class, 
        function ($app) {
            return new GeoLocationService($app->make(GeoLocationClient::class),
                                        $app->make(GeoLocation::class));
        });

        $this->app->singleton(WeatherDataService::class, function ($app) {
            return new WeatherDataService($app->make(WeatherDataClient::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
