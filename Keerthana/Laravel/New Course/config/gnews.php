<?php

use Carbon\Carbon;

return [
    'from' => Carbon::now()->subDays(2)->toIso8601String(), //2days form now
    'to' => Carbon::now()->subHours(13)->toIso8601String(), //13hrs from now
];
