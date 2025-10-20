<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse 
{
    public  array $response = [];

    public function __construct(array $response = []){
        $this->response = $response;
    }

    public function setMessage(string $message, bool $isSuccess = true)
    {
        $this->response['status'] = $isSuccess;
        $this->response['message'] = $message;
        return  $this->response;
    }
    public  function setData(array $data)
    {
        $this->response['data'] = $data;
        return $this->response;
    }

    public  function retrunResponse(int $code = 200): JsonResponse
    {
        return response()->json($this->response, $code);
    }
}