<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message, $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    protected function createdResponse($data, $message = 'Resource created successfully')
    {
        return $this->successResponse($data, $message, 201);
    }

    protected function noContentResponse($message = 'Resource deleted successfully')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ], 204);
    }
}