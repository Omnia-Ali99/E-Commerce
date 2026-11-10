<?php

namespace App\Traits;

trait ApiResponse
{

    protected function apiResponse($data, $status, $msg, $code)
    {
        $response = [
            'status' => $status,
            'message' => $msg,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }
}
