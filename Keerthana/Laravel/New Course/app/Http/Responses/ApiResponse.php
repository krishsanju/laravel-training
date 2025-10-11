<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse 
{
    // // public static function setMessage($data, $message){
    // //     return response()->json([
    // //         'status' => 'success',
    // //         'message'=> $message,
    // //         'data'=> $data,
    // //     ]);
    // // }

    // // public static function mergeResponse($data){

    // // }

    // public static function setMessage($data, $message): ApiResponseBuilder
    // {
    //     return new ApiResponseBuilder($data, $message);
    // }




    // // public static function userRegistrationSuccess($data): JsonResponse{
    // //     return response()->json([
    // //         'status' => 'Success',
    // //         'message' => 'User registered and logged in successfully!',
    // //         'user' => $data
    // //     ]);
    // // }

    // // public static function loginRegistrationSuccess($data){
    // //     response()->json([
    // //         'status' => 'login done',
    // //         'user' => $data
    // //     ]);
    // // }

    // public static function postSubmissionSuccess($data){
    //     return response()->json([
    //         'status' => 'Success',
    //         'post' => $data,
    //         'article' => $data->article 
    //     ]); 
    // }

    // // public static function postDeletion($data){
    // //     return response()->json([
    // //             'status'=> 'Delete post and article associated with it',
    // //             'post'=> $data,
    // //         ]);
    // // }




    protected static string $status = 'success';
    protected static string $message = '';
    protected static mixed $data = null;

    public static function setMessage($data, $message): static
    {
        self::$data = $data;
        self::$message = $message;

        return new static(); 
    }

    public function mergeResponse(string $extra): static
    {
        self::$message = $extra . self::$message;
        return $this;
    }

    public function send(int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => self::$status,
            'message' => self::$message,
            'data' => self::$data,
        ], $statusCode);
    }



    
} 