<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CorrelationIdTest extends TestCase
{
    use RefreshDatabase;

    /** Helper: authenticate with non-persisted user */
    private function auth()
    {
        Sanctum::actingAs(
            User::factory()->make(), // tidak masuk DB
            ['*']
        );
    }

    /** @test */
    public function response_contains_correlation_id_header()
    {
        $this->auth();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);

        // Pastikan header ada
        $response->assertHeader('X-Correlation-ID');

        // Pastikan tidak kosong
        $this->assertNotEmpty($response->headers->get('X-Correlation-ID'));
    }

    /** @test */
    public function correlation_id_is_propagated_if_sent_in_request()
    {
        $this->auth();

        $customId = 'TEST-CID-12345';

        $response = $this->getJson('/api/users', [
            'X-Correlation-ID' => $customId
        ]);

        $response->assertStatus(200);

        // Pastikan header diberi kembali ke client
        $response->assertHeader('X-Correlation-ID', $customId);
    }

    /** @test */
    public function correlation_id_is_generated_if_missing()
    {
        $this->auth();

        $response = $this->getJson('/api/users');

        $cid = $response->headers->get('X-Correlation-ID');

        $this->assertNotEmpty($cid);

        // Format UUID (opsional)
        $this->assertMatchesRegularExpression(
            '/^[0-9a-fA-F-]{36}$/',
            $cid,
            "Correlation ID should be UUID"
        );
    }
}
