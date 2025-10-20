<?php

namespace App\Providers;

use App\Clients\GnewsClient;
use App\Service\GnewsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GnewsClient::class, fn() => new GnewsClient());

        $this->app->singleton(GnewsService::class, function($app){
            return new GnewsService($app->make(GnewsClient::class));
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
