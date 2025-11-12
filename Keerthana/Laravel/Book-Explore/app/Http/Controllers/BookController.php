<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\ApiResponse;
use Illuminate\Http\Response;
use App\Services\BooksService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\SearchBooksRequest;

class BookController extends Controller
{
    protected BooksService $booksService;

    public function __construct(BooksService $booksService)
    {
        $this->booksService = $booksService;
    }
    public function search(SearchBooksRequest $request)
    {
        $books = $this->booksService->searchBooks($request->q);

        return ApiResponse::setMessage('Books fetched from API')
                ->setData($books)
                ->response(Response::HTTP_OK);
    }

    public function store(StoreBookRequest  $request)
    {
        $result = $this->booksService->storeBook($request->validated());

        return ApiResponse::setMessage('Book saved successfully')
                ->setData($result['book'])
                ->response(Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $book = $this->booksService->getBook($id);

        if(!$book){
            return ApiResponse::setMessage('Book not found')
                    ->response(Response::HTTP_NOT_FOUND);
        }

        return ApiResponse::setMessage('Book details')
                ->setData($book)
                ->response(Response::HTTP_OK);

    }
}
