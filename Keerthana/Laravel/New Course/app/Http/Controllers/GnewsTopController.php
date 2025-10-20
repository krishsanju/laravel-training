<?php

namespace App\Http\Controllers;

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
    public function fetchNews(Request $request){

        $response = $this->gnewsService->fetchNews();

        $apiResponse = new ApiResponse;
        if($response){
            $apiResponse->setMessage('Retrieved the top news');
            // $apiResponse->setData($response);
            return $apiResponse->returnResponse(200);
        }
        else{
            $apiResponse->setMessage('Unable to retrive');
            return $apiResponse->returnResponse(500);
        }
    }
}
