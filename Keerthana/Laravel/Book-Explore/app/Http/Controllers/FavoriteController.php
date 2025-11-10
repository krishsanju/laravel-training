<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\ApiResponse;
use Illuminate\Http\Response;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function add(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
        ]);

        $userId = auth()->id();  //when we give bearer token we get the user details
        $result = $this->favoriteService->addFavorite($userId, $request->book_id);

        if (!$result) {
            return ApiResponse::setMessage('Book already in favorites')
                ->response(Response::HTTP_CONFLICT);
        }

        return ApiResponse::setMessage('Book added to favorites')
            ->setData($result)
            ->response(Response::HTTP_CREATED);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
        ]);

        $userId = auth()->id();
        $removed = $this->favoriteService->removeFavorite($userId, $request->book_id);

        if (!$removed) {
            return ApiResponse::setMessage('Book not found in favorites')
                ->response(Response::HTTP_NOT_FOUND);
        }

        return ApiResponse::setMessage('Book removed from favorites')
            ->response(Response::HTTP_OK);
    }

    public function list()
    {
        $userId = auth()->id();

        $favorites = $this->favoriteService->listFavorites($userId);

        return ApiResponse::setMessage('Favorite books list')
            ->setData($favorites)
            ->response(Response::HTTP_OK);
    }
}
