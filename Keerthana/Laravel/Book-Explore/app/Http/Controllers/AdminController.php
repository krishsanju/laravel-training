<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Response\ApiResponse;
use Illuminate\Http\Response;
use App\Services\ReviewService;
use App\Services\FavoriteService;

class AdminController extends Controller
{
    protected FavoriteService $favoriteService;
    protected ReviewService $reviewService;

    public function __construct(FavoriteService $favoriteService, ReviewService $reviewService)
    {
        $this->favoriteService = $favoriteService;
        $this->reviewService = $reviewService;
    }
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

    public function getAllFavorites()
    {
        $favorites = $this->favoriteService->getAllFavorites();

        return ApiResponse::setMessage('All users favorite books')
            ->setData($favorites)
            ->response(Response::HTTP_OK);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
        ]);

        $removed = $this->reviewService->removeReview($request->user_id, $request->book_id);

        if (!$removed) {
            return ApiResponse::setMessage('Review not found')
                ->response(Response::HTTP_NOT_FOUND);
        }

        return ApiResponse::setMessage('Review removed')
            ->response(Response::HTTP_OK);
    }
}
