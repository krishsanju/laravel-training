<?php

namespace App\Services;

use App\Repositories\FavoritesRepository;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    protected FavoritesRepository $favoritesRepo;

    public function __construct(FavoritesRepository $favoritesRepo)
    {
        $this->favoritesRepo = $favoritesRepo;
    }

    public function addFavorite(int $userId, int $bookId): Favorite|bool
    {
        if ($this->favoritesRepo->exists($userId, $bookId)) {
            return false;
        }

        $favorite = $this->favoritesRepo->addFavorite($userId, $bookId);

        return $favorite;
    }

    public function removeFavorite(int $userId, int $bookId): bool
    {
        return $this->favoritesRepo->removeFavorite($userId, $bookId);
    }

    public function listFavorites(int $userId)
    {
        return $this->favoritesRepo->listFavorites($userId);
    }

    public function getAllFavorites()
    {
        return $this->favoritesRepo->getAllWithUserAndBook();
    }
}