<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

class OpenLibraryClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.open_library.base_url');
    }

    public function searchBooks(string $query): ?array
    {
        try {
            $response = Http::timeout(10)
                ->acceptJson()
                ->get("{$this->baseUrl}/search.json", [
                    'q' => $query,
                    'limit' => 20
                ]);

            if ($response->failed()) {
                throw new RequestException($response);
            }

            return $response->json();
        } catch (\Throwable $e) {
            Log::error('OpenLibrary searchBooks failed', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

}