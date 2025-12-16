<?php

namespace App\Http\Controllers\Gateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserGatewayController
{
    public function store(Request $request)
    {
        $cid = $request->header('X-Correlation-ID') ?? uniqid('cid-');

        Log::info('[Gateway] POST /users', [
            'correlation_id' => $cid,
            'body' => $request->all()
        ]);

        $response = Http::withHeaders([
            'X-Correlation-ID' => $cid,
            'Accept' => 'application/json'
        ])->post('http://127.0.0.1:8001/api/users', $request->all());

        return response()->json(
            $response->json(),
            $response->status()
        )->header('X-Correlation-ID', $cid);
    }
}
