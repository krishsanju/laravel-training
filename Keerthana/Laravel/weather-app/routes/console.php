<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('wether:update')->everyMinute()
    ->when(function(){
        return in_array(Carbon::now()->day, [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::SATURDAY]);
    })
    ->before(function () {
        Log::info('Running wether:minute scheduler');
    });

// Schedule::command('wether:update')
//     ->everyMinute()
//     ->days([Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::SATURDAY])
//     ->before(function () {
//         Log::info('Running wether:weekly scheduler');
//     });



