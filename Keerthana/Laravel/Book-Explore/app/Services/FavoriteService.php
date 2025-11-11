<?php

namespace App\Services;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FavoritesRepository;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\FavoriteAlreadyExistsException;

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
            throw new FavoriteAlreadyExistsException();
        }

        $favorite = $this->favoritesRepo->addFavorite($userId, $bookId);

        return $favorite;
    }

    public function removeFavorite(int $userId, int $bookId)
    {
        $removed = $this->favoritesRepo->removeFavorite($userId, $bookId);

        if (!$removed) {
            throw new ResourceNotFoundException('Favorite book');
        }
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