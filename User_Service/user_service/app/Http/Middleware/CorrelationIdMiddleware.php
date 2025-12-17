<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CorrelationIdMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil dari header (case-insensitive), kalau kosong generate
        $correlationId = $request->headers->get('X-Correlation-ID');

        if (empty($correlationId)) {
            $correlationId = (string) Str::uuid();
        }

        // Simpan ke attributes (bukan session)
        $request->attributes->set('correlation_id', $correlationId);

        // Pastikan header request ada (berguna untuk service lain / log)
        $request->headers->set('X-Correlation-ID', $correlationId);

        // Context logger
        Log::withContext([
            'correlation_id' => $correlationId,
        ]);

        $response = $next($request);

        // Tambahkan header ke response (kalau response object punya headers)
        if (method_exists($response, 'headers')) {
            $response->headers->set('X-Correlation-ID', $correlationId);
        }

        return $response;
    }
}
