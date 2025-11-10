<?php

namespace App\Repositories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;

class FavoritesRepository
{
    public function addFavorite(int $userId, int $bookId): Favorite
    {
        return Favorite::create([
            'user_id' => $userId,
            'book_id' => $bookId,
        ]);
    }

    public function removeFavorite(int $userId, int $bookId): bool
    {
        return Favorite::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->delete();
    }


    public function listFavorites(int $userId): Collection
    {
        return Favorite::with('book')
            ->where('user_id', $userId)
            ->get();
    }

    public function exists(int $userId, int $bookId): bool
    {
        return Favorite::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->exists();
    }

    public function getAllWithUserAndBook()
    {
        return Favorite::with('book', 'user')->get();
    }
}