<?php

namespace App\Service;

use App\Models\GnewsTop;
use App\Enums\Categories;
use App\Clients\GnewsClient;

class GnewsService
{
    protected GnewsClient $gnewsClient;

    public function __construct(GnewsClient $gnewsClient){
        $this->gnewsClient = $gnewsClient;
    }

    public function fetchNews(){
        try {
            foreach (Categories::getInstances() as $categoryEnum) {
                $categoryKey = strtolower($categoryEnum->key);  // e.g., "general"
                $articles = $this->gnewsClient->fetchTopHeadlines($categoryKey);
                GnewsTop::storeArticles($articles, $categoryEnum->value); // 👈 pass integer value
            }
            return true;
        } catch (\Exception $e) {
            info($e->getMessage());
            return false;
        }
        
    }
}