<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class GatewayOrchestrationTest extends TestCase
{
    public function test_orchestrate_forwards_auth_and_correlation()
    {
        Http::fake(function ($request) {
            // Ensure correlation id and authorization exist on proxied requests
            $this->assertTrue($request->hasHeader('X-Correlation-ID'));
            $this->assertTrue($request->hasHeader('Authorization'));

            if (str_contains($request->url(), '/api/users/')) {
                return Http::response([
                    'data' => [
                        'id' => 1,
                        'name' => 'User A'
                    ]
                ], 200);
            }

            if (str_contains($request->url(), '/api/clubs/user/')) {
                return Http::response([
                    'data' => [
                        [
                            'id' => 2,
                            'name' => 'Club B'
                        ]
                    ]
                ], 200);
            }

            return Http::response([], 404);
        });

        $response = $this->getJson(
            '/api/orchestrate/user/1',
            ['Authorization' => 'Bearer test-token']
        );

        $response->assertStatus(200);

        $response->assertJsonPath('data.user.id', 1);
        $response->assertJsonPath('data.clubs.0.id', 2);

        $this->assertNotEmpty($response->json('meta.correlation_id'));
    }
}
