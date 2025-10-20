<?php

namespace App\Http\Response;

class ApiResponse
{
    protected array $response = [];

    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    public function setMessage($message)
    {
        $this->response['message'] = $message;
        return $this;
    }

    public function setToken($token)
    {
        $this->response['token'] = $token;
        return $this;
    }

    public function setData(array $data)
    {
        $this->response['data'] = $data;
        return $this;
    }

    public function returnResponse($code = 200)
    {
        return response()->json($this->response, $code);
    }
}
