<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse 
{
    public static array $response = [];

    // public static function setMessage($data = null, $message , $code = 200)
    // {
    //     return response()->json([
    //         'success' => true,
    //         'message' => $message,
    //         'data'    => $data,
    //     ], $code);
    // }

    // public static function error($message = 'Something went wrong', $code = 500, $data = null)
    // {
    //     return response()->json([
    //         'success' => false,
    //         'message' => $message,
    //         'data'    => $data,
    //     ], $code);
    // }

    public static function setMessage(string $message, bool $isSuccess = true)
    {
        self::$response['status'] = $isSuccess;
        self::$response['message'] = $message;
        return new self;
    }

    public static function setData(array $data)
    {
        self::$response['data'] = $data;
        return new self;

    }

    public static function retrunResponse(int $code = 200): JsonResponse
    {
        return response()->json(self::$response, $code);
    }
}