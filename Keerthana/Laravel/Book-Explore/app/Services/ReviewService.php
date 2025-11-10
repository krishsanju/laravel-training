<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\ReviewRepository;

class ReviewService
{
    protected ReviewRepository $reviewRepo;

    public function __construct(ReviewRepository $reviewRepo)
    {
        $this->reviewRepo = $reviewRepo;
    }

    public function addReview(int $userId, $data)
    {
        if ($this->reviewRepo->exists($userId, $data['book_id'])) {
            return false;
        }

        $favorite = $this->reviewRepo->addReview($userId, $data);

        return $favorite;
    }

    public function removeReview(int $userId, int $bookId): bool
    {
        return $this->reviewRepo->removeReview($userId, $bookId);
    }

    // public function listFavorites(int $userId)
    // {
    //     return $this->reviewRepo->listFavorites($userId);
    // }

    // public function getAllFavorites()
    // {
    //     return $this->reviewRepo->getAllWithUserAndBook();
    // }
}