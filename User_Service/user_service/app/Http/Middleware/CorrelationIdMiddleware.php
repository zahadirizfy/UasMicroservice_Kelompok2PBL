<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CorrelationIdMiddleware
{
    public function handle($request, Closure $next)
    {
        // Ambil X-Correlation-ID dari request — atau buat baru
        $correlationId = $request->header('X-Correlation-ID') ?? (string) Str::uuid();

        // Simpan ke attributes (bisa diambil controller lain)
        $request->attributes->set('correlation_id', $correlationId);

        // Tambahkan ke context Logger
        Log::withContext([
            'correlation_id' => $correlationId
        ]);

        // Lanjut request
        $response = $next($request);

        // Tambahkan header ke response
        $response->headers->set('X-Correlation-ID', $correlationId);

        return $response;
    }
}
