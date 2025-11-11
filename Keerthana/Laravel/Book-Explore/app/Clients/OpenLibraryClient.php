<?php

namespace App\Clients;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ExternalApiException;
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
                    // 'limit' => 20
                ]);

            if ($response->failed()) {
                throw ExternalApiException::badResponse('OpenLibrary', $response->body());
            }

            return $response->json();
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            throw ExternalApiException::timeout('OpenLibrary');
        } catch (\Throwable $e) {
            Log::error('OpenLibrary searchBooks failed', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);
            throw new ExternalApiException('Failed to communicate with OpenLibrary API.');
        }
    }

}