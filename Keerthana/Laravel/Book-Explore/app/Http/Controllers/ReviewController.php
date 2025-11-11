<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\ApiResponse;
use Illuminate\Http\Response;
use App\Services\ReviewService;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    public function add(ReviewRequest $request)
    {
        $userId = auth()->id();
        $result = $this->reviewService->addReview($userId, $request);

        return ApiResponse::setMessage('Review added')
            ->setData($result)
            ->response(Response::HTTP_CREATED);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
        ]);

        $userId = auth()->id();
        $this->reviewService->removeReview($userId, $request->book_id);

        return ApiResponse::setMessage('Review removed')
            ->response(Response::HTTP_OK);
    }

    // public function list()
    // {
    //     $userId = auth()->id();

    //     $favorites = $this->reviewService->listReview($userId);

    //     return ApiResponse::setMessage('Review list')
    //         ->setData($favorites)
    //         ->response(Response::HTTP_OK);
    // }
}
