<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Middleware Correlation ID (PUNYA LO — TETAP)
        $middleware->append(\App\Http\Middleware\CorrelationIdMiddleware::class);

        // 🔥 TAMBAHAN WAJIB — DISABLE CSRF UNTUK API
        $middleware->append(\App\Http\Middleware\VerifyCsrfToken::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // --- LOGIKA GLOBAL ERROR HANDLER (PUNYA LO — TETAP) ---

        // 1. Paksa format JSON jika request datang ke API
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }
            return $request->expectsJson();
        });

        // 2. Kustomisasi Format Error JSON
        $exceptions->render(function (Throwable $e, Request $request) {

            if ($request->is('api/*') || $request->expectsJson()) {

                $statusCode = method_exists($e, 'getStatusCode')
                    ? $e->getStatusCode()
                    : 500;

                return response()->json([
                    'status' => 'error',
                    'meta' => [
                        'correlation_id' => Context::get('correlation_id'),
                        'timestamp' => now()->toIso8601String()
                    ],
                    'error' => [
                        'code' => $statusCode,
                        'message' => $e->getMessage(),
                    ]
                ], $statusCode);
            }
        });
    })->create();
