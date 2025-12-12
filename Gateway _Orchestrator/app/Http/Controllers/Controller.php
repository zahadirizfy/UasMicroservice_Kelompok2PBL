<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function successResponse(mixed $data, array $meta = [], int $status = 200)
    {
        $defaultMeta = [
            'timestamp' => now()->toIso8601String(),
        ];

        $meta = array_merge($defaultMeta, $meta);

        return response()->json([
            'status' => 'success',
            'meta' => $meta,
            'data' => $data,
        ], $status);
    }

    protected function errorResponse(string $message, int $code = 500, array $meta = [])
    {
        $defaultMeta = [
            'timestamp' => now()->toIso8601String(),
        ];

        $meta = array_merge($defaultMeta, $meta);

        return response()->json([
            'status' => 'error',
            'meta' => $meta,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ], $code);
    }
}
