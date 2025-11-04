<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Responses\ApiResponse;

class UserActivityController extends Controller
{
    public function __construct(private ApiResponse $apiResponse) {}
    public function checkIsFraud(Request $request)
    {
        $userId = $request->validate([
            'user' => 'required'
        ]);
        if (UserActivity::isFraud($userId)) {
            $response = "User is fraud today!";
        } else {
            $response = "User is fine.";
        }

        return $this->apiResponse->setMessage($response)
                            ->response(Response::HTTP_OK);
    }
}
