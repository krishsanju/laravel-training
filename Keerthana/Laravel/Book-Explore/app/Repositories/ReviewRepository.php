<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository
{

    public function addReview(int $userId,  $data)
    {
        return Review::create([
            'user_id' => $userId,
            'book_id' => $data['book_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);
    }
    public function exists(int $userId, int $bookId): bool
    {
        return Review::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->exists();
    }

    public function removeReview(int $userId, int $bookId): bool
    {
        return Review::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->delete();
    }
}
