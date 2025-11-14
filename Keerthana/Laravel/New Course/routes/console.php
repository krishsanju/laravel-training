<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\FetchDailyExchangeRatesJob;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(new FetchDailyExchangeRatesJob())->dailyAt('09:03');
// Schedule::job(new FetchDailyExchangeRatesJob())->everyMinute();