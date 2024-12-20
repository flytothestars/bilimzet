<?php

namespace App\Helper;

class ApiResponseHelper
{
    public static function success($data = [], $message = 'Request successful', $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public static function error($message = 'An error occurred', $statusCode = 400, $data = [])
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $data
        ], $statusCode);
    }
}
