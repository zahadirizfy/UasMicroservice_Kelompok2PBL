<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClubApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test dapat membuat club baru via API.
     */
    public function test_can_create_club(): void
    {
        // Buat user terlebih dahulu
        $user = User::factory()->create();

        $clubData = [
            'nama' => 'Club Silat Jaya',
            'lokasi' => 'Jakarta Selatan',
            'deskripsi' => 'Club silat terbaik di Jakarta',
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/v1/clubs', $clubData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Club berhasil ditambahkan',
            ])
            ->assertJsonPath('data.nama', 'Club Silat Jaya')
            ->assertJsonPath('data.lokasi', 'Jakarta Selatan');

        $this->assertDatabaseHas('clubs', [
            'nama' => 'Club Silat Jaya',
            'lokasi' => 'Jakarta Selatan',
        ]);
    }

    /**
     * Test validasi gagal saat nama kosong.
     */
    public function test_create_club_validation_fails_without_nama(): void
    {
        $user = User::factory()->create();

        $clubData = [
            'lokasi' => 'Jakarta Selatan',
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/v1/clubs', $clubData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validasi gagal',
            ])
            ->assertJsonValidationErrors(['nama']);
    }

    /**
     * Test validasi gagal saat lokasi kosong.
     */
    public function test_create_club_validation_fails_without_lokasi(): void
    {
        $user = User::factory()->create();

        $clubData = [
            'nama' => 'Club Silat Jaya',
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/v1/clubs', $clubData);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validasi gagal',
            ])
            ->assertJsonValidationErrors(['lokasi']);
    }

    /**
     * Test dapat mengambil daftar clubs.
     */
    public function test_can_get_club_list(): void
    {
        $user = User::factory()->create();
        Club::factory()->count(5)->forUser($user)->create();

        $response = $this->getJson('/api/v1/clubs');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Daftar club berhasil diambil',
            ])
            ->assertJsonCount(5, 'data');
    }

    /**
     * Test dapat mengambil detail club.
     */
    public function test_can_get_club_detail(): void
    {
        $user = User::factory()->create();
        $club = Club::factory()->forUser($user)->create([
            'nama' => 'Club Test Detail',
        ]);

        $response = $this->getJson("/api/v1/clubs/{$club->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Detail club berhasil diambil',
            ])
            ->assertJsonPath('data.nama', 'Club Test Detail');
    }

    /**
     * Test 404 ketika club tidak ditemukan.
     */
    public function test_get_club_detail_returns_404_when_not_found(): void
    {
        $response = $this->getJson('/api/v1/clubs/9999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Club tidak ditemukan',
            ]);
    }

    /**
     * Test dapat mengupdate club.
     */
    public function test_can_update_club(): void
    {
        $user = User::factory()->create();
        $club = Club::factory()->forUser($user)->create();

        $updateData = [
            'nama' => 'Club Updated',
            'lokasi' => 'Bandung',
        ];

        $response = $this->putJson("/api/v1/clubs/{$club->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Club berhasil diperbarui',
            ])
            ->assertJsonPath('data.nama', 'Club Updated')
            ->assertJsonPath('data.lokasi', 'Bandung');

        $this->assertDatabaseHas('clubs', [
            'id' => $club->id,
            'nama' => 'Club Updated',
            'lokasi' => 'Bandung',
        ]);
    }

    /**
     * Test dapat menghapus club.
     */
    public function test_can_delete_club(): void
    {
        $user = User::factory()->create();
        $club = Club::factory()->forUser($user)->create();

        $response = $this->deleteJson("/api/v1/clubs/{$club->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Club berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('clubs', [
            'id' => $club->id,
        ]);
    }

    /**
     * Test delete returns 404 ketika club tidak ditemukan.
     */
    public function test_delete_club_returns_404_when_not_found(): void
    {
        $response = $this->deleteJson('/api/v1/clubs/9999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Club tidak ditemukan',
            ]);
    }

    /**
     * Test response memiliki header X-Correlation-ID.
     */
    public function test_response_has_correlation_id_header(): void
    {
        $response = $this->getJson('/api/v1/clubs');

        $response->assertHeader('X-Correlation-ID');
    }

    /**
     * Test dapat mengirim custom Correlation ID.
     */
    public function test_can_send_custom_correlation_id(): void
    {
        $customCorrelationId = 'custom-test-correlation-id-123';

        $response = $this->withHeaders([
            'X-Correlation-ID' => $customCorrelationId,
        ])->getJson('/api/v1/clubs');

        $response->assertHeader('X-Correlation-ID', $customCorrelationId);
    }

    /**
     * Test health check endpoint.
     */
    public function test_health_check_endpoint(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
                'service' => 'club-service',
            ])
            ->assertJsonStructure([
                'status',
                'service',
                'timestamp',
            ]);
    }
}

