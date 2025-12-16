<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;

class ApiGatewayController extends Controller
{
    protected function proxyGet(Request $request, string $url)
    {
        $correlationId = Context::get('correlation_id');

        $headers = [
            'X-Correlation-ID' => $correlationId,
        ];

        if ($request->header('Authorization')) {
            $headers['Authorization'] = $request->header('Authorization');
        }

        try {
            $resp = Http::withHeaders($headers)
                        ->timeout(5)
                        ->get($url);

            if ($resp->failed()) {
                Log::error("Upstream service returned failure: {$url}", [
                    'status' => $resp->status(),
                    'correlation_id' => $correlationId,
                ]);

                return $this->errorResponse('Upstream service error', 502, ['correlation_id' => $correlationId]);
            }

            return $this->successResponse($resp->json(), ['correlation_id' => $correlationId]);

        } catch (\Exception $e) {
            Log::error('Error proxying request', ['exception' => $e->getMessage(), 'correlation_id' => $correlationId]);

            return $this->errorResponse('Failed to reach upstream service', 502, ['correlation_id' => $correlationId]);
        }
    }

    public function getUser(Request $request, $id)
    {
        $base = config('services.user.base');
        $url = rtrim($base, '/') . "/api/users/{$id}";

        return $this->proxyGet($request, $url);
    }

    public function getClub(Request $request, $id)
    {
        $base = config('services.club.base');
        $url = rtrim($base, '/') . "/api/clubs/{$id}";

        return $this->proxyGet($request, $url);
    }

    public function orchestrate(Request $request, $userId)
{
    $correlationId = Context::get('correlation_id');

    // 1️⃣ Call USER SERVICE
    $userResponse = Http::withHeaders([
        'X-Correlation-ID' => $correlationId,
        'Authorization'   => $request->header('Authorization'),
    ])->get(
        rtrim(config('services.user.base'), '/') . "/api/users/{$userId}"
    );

    if ($userResponse->failed()) {
        return $this->errorResponse(
            'User service unavailable',
            502,
            ['correlation_id' => $correlationId]
        );
    }

    // 2️⃣ Call CLUB SERVICE
    $clubResponse = Http::withHeaders([
        'X-Correlation-ID' => $correlationId,
        'Authorization'   => $request->header('Authorization'),
    ])->get(
        rtrim(config('services.club.base'), '/') . "/api/clubs/user/{$userId}"
    );

    if ($clubResponse->failed()) {
        return $this->errorResponse(
            'Club service unavailable',
            502,
            ['correlation_id' => $correlationId]
        );
    }

    // 3️⃣ Return gabungan
    return $this->successResponse([
        'user'  => $userResponse->json()['data'],
        'clubs'=> $clubResponse->json()['data'],
    ], [
        'correlation_id' => $correlationId
    ]);
}

}
