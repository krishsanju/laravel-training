<?php

namespace App\Clients;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GnewsClient
{
    public function fetchTopHeadlines($category)
    {

        info('in client');
        $from = Carbon::now()->subDays(2)->toIso8601String();      // 2 days ago
        $to = Carbon::now()->subHours(13)->toIso8601String();

        return Http::withoutVerifying()->get(config('services.endPoints.gnewsTopHeadlines'),[
            'category' => $category,
            'lang' => 'en',
            'country' => 'in',
            'max' => 5,
            'from' => $from,
            'to' => $to,
            'token' => config('services.apiKeys.gnews')
        ]);

        // info($response);

        // return $response->json();
    }
}