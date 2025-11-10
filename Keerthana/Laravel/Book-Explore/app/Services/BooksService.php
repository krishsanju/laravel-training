<?php

namespace App\Services;

use App\Clients\OpenLibraryClient;
use Illuminate\Support\Facades\Http;
use App\Repositories\BooksRepository;

class BooksService
{
    protected BooksRepository $bookRepo;
    protected OpenLibraryClient $client;

    public function __construct(BooksRepository $bookRepo, OpenLibraryClient $client)
    {
        $this->bookRepo = $bookRepo;
        $this->client = $client;
    }
    function searchBooks(string $query)
    {
        $response = $this->client->searchBooks($query);
        $books = $response['docs'] ?? [];

        if (empty($books)) {
            return [];
        }

        $firstBook = $books[0];

        return [
            'api_book_id' => $firstBook['key'] ?? null,
            'title' => $firstBook['title'] ?? null,
            'author' => isset($firstBook['author_name'][0]) ? $firstBook['author_name'][0] : null,
            'publisher' => isset($firstBook['publisher'][0]) ? $firstBook['publisher'][0] : null,
            'publish_date' => isset($firstBook['first_publish_year']) ? $firstBook['first_publish_year'] : null,
            'number_of_pages' => $firstBook['number_of_pages_median'] ?? null,
            'description' => $firstBook['subtitle'] ?? null,
        ];
    }

    public function storeBook(array $data)
    {
        $exists = $this->bookRepo->findByApiId($data['api_book_id']);

        if ($exists) {
            return ['exists' => true, 'book' => $exists];
        }

        $book = $this->bookRepo->create($data);
        return ['exists' => false, 'book' => $book];
    }

    public function getBook($id)
    {
        return $this->bookRepo->find($id);
    }
}
