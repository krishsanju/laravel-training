<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\UserActivity;

class ChangePasswordController extends Controller
{
    public function __construct(private ApiResponse $apiResponse) {}
    public function update(ChangePasswordRequest $request)
    {
        $user = $request->user();

        if(! Hash::check($request->currentPassword , $user->password))
        {
            return $this->apiResponse->setMessage("Current password is incorrect")
                                ->response(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        User::updatePassword($user, $request->password);

        $activity  = UserActivity::incrementPasswordChange($user);
        return $this->apiResponse->setMessage("Password updated successfully")
                            ->response(Response::HTTP_OK);
    }
}
