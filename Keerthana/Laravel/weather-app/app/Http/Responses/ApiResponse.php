<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse 
{
    public static function setMessage($data = null, $message , $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public static function error($message = 'Something went wrong', $code = 500, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}