<?php

namespace App\Http\Controllers;

use App\Models\GnewsTop;
use Illuminate\Http\Request;
use App\Service\GnewsService;
use App\Http\Responses\ApiResponse;

class GnewsTopController extends Controller
{
    protected GnewsService $gnewsService;
    public function __construct(GnewsService $gnewsService)
    {
        $this->gnewsService = $gnewsService;
    }
    public function fetchNews(){

        $response = $this->gnewsService->fetchNews();
        info($response);

        $apiResponse = new ApiResponse;
        if($response){
            $apiResponse->setMessage('Retrieved the top news');
            return $apiResponse->returnResponse(200);
        }
        else{
            $apiResponse->setMessage('Unable to retrive');
            return $apiResponse->returnResponse(500);
        }
    }


    public function categoryNews(Request $request)
    {
        $category = $request->input('category');
        $response = GnewsTop::fetchCategoryNews($category);
        info($response);

        $apiResponse = new ApiResponse;
        if ($response->isEmpty()) {
            $apiResponse->setMessage('No data found for this category');
            return $apiResponse->returnResponse(404);
        }

        $apiResponse->setMessage('Retrieved data successfully');
        $apiResponse->setData($response->toArray());
        return $apiResponse->returnResponse(200);

    }
}
