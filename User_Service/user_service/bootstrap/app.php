<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CorrelationIdMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        /**
         * 1) GLOBAL middleware (jalan di web & api)
         * Correlation ID aman untuk semua request
         */
        $middleware->append(CorrelationIdMiddleware::class);

        /**
         * 2) Alias route middleware
         */
        $middleware->alias([
            'correlation.id' => CorrelationIdMiddleware::class,
        ]);

        /**
         * 3) CSRF hanya untuk WEB (jangan global!)
         * Kalau dipasang global, request API bisa kena masalah session/CSRF.
         */
        $middleware->web(append: [
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        // NOTE:
        // Jangan append VerifyCsrfToken secara global.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
