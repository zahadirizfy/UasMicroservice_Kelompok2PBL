<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Context;

class ExternalService
{
    public function fetchData($endpoint)
    {
        $correlationId = Context::get('correlation_id');

        try {
            // Panggil service lain dengan menyertakan Correlation ID
            $response = Http::withHeaders(['X-Correlation-ID' => $correlationId])
                            ->timeout(2) // Fail fast (2 detik)
                            ->get($endpoint);

            if ($response->failed()) {
                throw new \Exception("Service External Error: " . $response->status());
            }

            return $response->json();

        } catch (\Exception $e) {
            // LOG ERROR (Wajib ada log agar tahu kalau ada masalah)
            Log::error("Service call failed: " . $e->getMessage());

            // MEKANISME FALLBACK
            return [
                'data' => [],
                'message' => 'Layanan sedang sibuk, menampilkan data default.',
                'is_fallback' => true
            ];
        }
    }
}