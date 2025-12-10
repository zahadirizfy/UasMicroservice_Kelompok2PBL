<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

class CorrelationIdMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ambil ID dari header (jika dari service lain) atau buat baru
        $correlationId = $request->header('X-Correlation-ID') ?? (string) Str::uuid();

        // 2. Simpan ke Log Context (Poin 3: agar muncul di setiap log)
        // Jika error "Context not found", gunakan Log::shareContext(['correlation_id' => ...]) untuk Laravel versi lama
        Context::add('correlation_id', $correlationId);

        // 3. Masukkan ke header request (untuk diteruskan ke service selanjutnya)
        $request->headers->set('X-Correlation-ID', $correlationId);

        $response = $next($request);

        // 4. Balikkan ID ke response header (untuk debugging client)
        $response->headers->set('X-Correlation-ID', $correlationId);

        return $response;
    }
}