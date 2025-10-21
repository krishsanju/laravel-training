<?php

namespace App\Clients;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GnewsClient
{
    public function fetchTopHeadlines($category)
    {
        try{
    
            $response =  Http::withoutVerifying()->get(config('services.endPoints.gnewsTopHeadlines'),[
                'category' => $category,
                'lang' => 'en',
                'country' => 'in',
                'max' => 5,
                'from' => config('gnews.from'),
                'to' => config('gnews.to'),
                'token' => config('services.apiKeys.gnews')
            ]);

            $data = $response->json();

            if (empty($data['articles'])) {
                throw new Exception("No articles found for category '{$category}'");
            }

            return $data['articles'];

        }catch (Exception $e) {
            info("Error fetching category {$category}: " . $e->getMessage());
            throw $e; 

        }
    }
}