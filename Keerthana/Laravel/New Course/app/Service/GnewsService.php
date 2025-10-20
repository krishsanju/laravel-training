<?php

namespace App\Service;

use App\Models\GnewsTop;
use App\Clients\GnewsClient;

class GnewsService
{
    protected GnewsClient $gnewsClient;

    public function __construct(GnewsClient $gnewsClient){
        $this->gnewsClient = $gnewsClient;
    }

    public function fetchNews(){
        // info('in Service');
        // $response =  $this->gnewsClient->fetchTopHeadlines()->json();
        // return GnewsTop::storeArticles($response['articles']);

        $categories = array('general', 'world', 'nation', 'business', 'technology', 'entertainment', 'sports', 'science' , 'health');


        foreach ($categories as $category) {
            info("Fetching category: $category");

            $response = $this->gnewsClient->fetchTopHeadlines($category)->json();

            GnewsTop::storeArticles($response['articles'], $category);
        }

        return true;
    }
}