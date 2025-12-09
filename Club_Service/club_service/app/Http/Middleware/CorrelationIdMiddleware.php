<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CorrelationIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Middleware untuk tracking request menggunakan Correlation ID.
     * Jika X-Correlation-ID header sudah ada (dari Gateway), gunakan yang ada.
     * Jika tidak ada, generate UUID baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Ambil X-Correlation-ID dari request — atau buat baru
        $correlationId = $request->header('X-Correlation-ID') ?? (string) Str::uuid();

        // Simpan ke attributes (bisa diambil controller lain)
        $request->attributes->set('correlation_id', $correlationId);

        // Tambahkan ke context Logger untuk JSON logging
        Log::withContext([
            'correlation_id' => $correlationId,
            'service' => 'club-service'
        ]);

        // Log incoming request
        Log::info('[ClubService] Incoming request', [
            'method' => $request->method(),
            'path' => $request->path(),
            'ip' => $request->ip(),
        ]);

        // Lanjut request
        $response = $next($request);

        // Tambahkan header ke response
        $response->headers->set('X-Correlation-ID', $correlationId);

        // Log outgoing response
        Log::info('[ClubService] Outgoing response', [
            'status' => $response->getStatusCode(),
        ]);

        return $response;
    }
}

