<?php

namespace App\Providers;


use App\Clients\CountryClient;
use App\Services\CountryService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CountryClient::class, fn () => new CountryClient());

        $this->app->singleton(CountryService::class , function($app){
            return new CountryService(
                $app->make(CountryClient::class)
            );
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
