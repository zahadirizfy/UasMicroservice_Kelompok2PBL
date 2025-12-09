<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CorrelationIdMiddleware
{
    /**
     * Header name for Correlation ID
     */
    public const HEADER_NAME = 'X-Correlation-ID';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Generate atau ambil Correlation ID dari header request
        $correlationId = $request->header(self::HEADER_NAME) ?? $this->generateCorrelationId();

        // Set Correlation ID ke request header (agar bisa diakses di controller)
        $request->headers->set(self::HEADER_NAME, $correlationId);

        // Set Correlation ID ke Log context
        Log::shareContext([
            'correlation_id' => $correlationId,
        ]);

        // Log incoming request
        Log::info('Incoming request', [
            'method' => $request->method(),
            'uri' => $request->getRequestUri(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Process request
        $response = $next($request);

        // Add Correlation ID ke response header
        $response->headers->set(self::HEADER_NAME, $correlationId);

        // Log outgoing response
        Log::info('Outgoing response', [
            'status_code' => $response->getStatusCode(),
            'method' => $request->method(),
            'uri' => $request->getRequestUri(),
        ]);

        return $response;
    }

    /**
     * Generate a new unique Correlation ID.
     */
    protected function generateCorrelationId(): string
    {
        return Str::uuid()->toString();
    }
}

