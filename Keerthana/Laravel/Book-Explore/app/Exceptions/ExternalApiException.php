<?php

namespace App\Exceptions;

use Exception;

class ExternalApiException extends Exception
{
    public function __construct(string $message = 'External API request failed.', int $code = 502)
    {
        parent::__construct($message, $code);
    }

    public static function timeout(string $service): self
    {
        return new self("Request to {$service} timed out.", 504);
    }

    public static function badResponse(string $service, string $message): self
    {
        return new self("{$service} API error: {$message}", 502);
    }
}
