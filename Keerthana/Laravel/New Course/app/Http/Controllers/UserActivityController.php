<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Responses\ApiResponse;

class UserActivityController extends Controller
{
    public function __construct(private ApiResponse $apiResponse, private UserActivity $userActivity) {}
    public function checkIsFraud(Request $request)
    {
        $userId = $request->validate([
            'user' => 'required'
        ]);
        $user = User::whereId($userId)->first();
        // dd($user);

        if (!$user) {
            return $this->apiResponse->setMessage("User not found")
                                    ->response(Response::HTTP_NOT_FOUND);
        }
        if ($this->userActivity->checkIfUserIsFraud($user)) {
            $response = "User is fraud today!";
        } else {
            $response = "User is fine.";
        }

        return $this->apiResponse->setMessage($response)
                            ->response(Response::HTTP_OK);
    }
}
