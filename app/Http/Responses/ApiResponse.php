<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse {

    public static function success($data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => true,
            'message' => $message,
        ], $code);
    }

    public static function error( string $message, $data = null, int $code = 500): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'success' => false,
            'message' => $message,
        ], $code);
    }


}
