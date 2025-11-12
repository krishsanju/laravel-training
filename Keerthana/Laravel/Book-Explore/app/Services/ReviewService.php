<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\ReviewRepository;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\ReviewAlreadyExistsException;

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
            throw new ReviewAlreadyExistsException();
        }

        return $this->reviewRepo->addReview($userId, $data);
    }

    public function removeReview(int $userId, int $bookId)
    {
        $removed = $this->reviewRepo->removeReview($userId, $bookId);

        if (!$removed) {
            throw new ResourceNotFoundException('Review');
        }
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