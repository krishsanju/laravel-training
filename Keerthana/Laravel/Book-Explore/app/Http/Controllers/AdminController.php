<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Response\ApiResponse;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        return ApiResponse::setMessage('Users fetched successfully')
            ->setData($users)
            ->response(Response::HTTP_OK);
    }

    // public function destroy($idToDelete, Request $request)
    // {
    //     $authUser = $request->id;
    //     info($authUser);
    //     info($idToDelete);
    //     if( $authUser === $idToDelete){
    //         return ApiResponse::setMessage('You cannot delete your own account')
    //                 ->response(Response::HTTP_FORBIDDEN);
    //     }

    //     $user = User::find($idToDelete);

    //     if(!$user){
    //         return ApiResponse::setMessage('User not found')
    //             ->response(Response::HTTP_NOT_FOUND);
    //     }

    //     $user->delete();

    //     return Apiresponse::setMessage('User deleted successfully')
    //         ->response(Response::HTTP_OK);

    // }
}
