<?php

namespace App\Response;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    protected array $response = [];
    protected ?string $message = null;
    protected array $results = [];

    public static function setMessage(string $message): self
    {
        $instance = new self;
        $instance->message = $message;
        $instance->response['message'] = $message;

        return $instance;
    }

    public static function setData($data): self
    {
        $instance = new self;
        $instance->response['data'] = $data;

        return $instance;
    }

    public function mergeResults(array $results = []): self
    {
        $this->results = array_merge($this->results, $results);
        $this->response = array_merge($this->response, $this->results);

        return $this;
    }

    public function response(int $statusCode = 200): JsonResponse
    {
        return response()->json($this->response, $statusCode);
    }
}
