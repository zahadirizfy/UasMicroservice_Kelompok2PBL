<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CorrelationIdMiddleware;

class MiddlewareTest extends TestCase
{
    /**
     * Test untuk memastikan Correlation ID otomatis ditambahkan.
     * (Tugas Poin 6)
     */
    public function test_correlation_id_is_attached_to_response(): void
    {
        // 1. Setup: Buat route dummy khusus untuk testing
        // Kita pasang middleware CorrelationIdMiddleware di route ini
        Route::middleware([CorrelationIdMiddleware::class])
            ->get('/_test/check-id', function () {
                return response()->json(['message' => 'Test Success']);
            });

        // 2. Act: Lakukan request ke route tersebut
        $response = $this->get('/_test/check-id');

        // 3. Assert: Pastikan status 200 OK
        $response->assertStatus(200);

        // 4. Assert (INTI TUGAS): Pastikan header X-Correlation-ID ada di response
        // Ini membuktikan bahwa middleware bekerja
        $this->assertNotNull(
            $response->headers->get('X-Correlation-ID'), 
            "Header X-Correlation-ID tidak ditemukan di response!"
        );
    }
}