<?php

namespace App\Repositories;

use App\Models\Book;

class BooksRepository
{
    public function find($id)
    {
        return Book::find($id);
    }

    public function findByApiId($apiBookId)
    {
        return Book::where('api_book_id', $apiBookId)->first();
    }

    public function create(array $data)
    {
        return Book::create($data);
    }
}