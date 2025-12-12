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

    public function orchestrate(Request $request, $userId, $clubId)
    {
        $correlationId = Context::get('correlation_id');

        $user = null;
        $club = null;

        // Call user service
        $userResult = $this->proxyGet($request, rtrim(config('services.user.base'), '/') . "/api/users/{$userId}");
        if ($userResult->getStatusCode() !== 200) {
            return $userResult;
        }

        $user = $userResult->getData(true)['data'] ?? null;

        // Call club service
        $clubResult = $this->proxyGet($request, rtrim(config('services.club.base'), '/') . "/api/clubs/{$clubId}");
        if ($clubResult->getStatusCode() !== 200) {
            return $clubResult;
        }

        $club = $clubResult->getData(true)['data'] ?? null;

        return $this->successResponse([
            'user' => $user,
            'club' => $club,
        ], ['correlation_id' => $correlationId]);
    }
}
