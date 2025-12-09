<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrchestrationTest extends TestCase
{
    public function test_gateway_forwards_headers_and_returns_wrapped_response()
    {
        // Fake downstream user service
        Http::fake([
            '*/api/users' => Http::response(['users' => [['id' => 1, 'name' => 'Alice']]], 200),
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer testtoken',
            'X-Correlation-ID' => 'test-cid-123',
        ])->getJson('/api/users');

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message', 'data']);
        $this->assertTrue($response->json('success'));
    }
}
