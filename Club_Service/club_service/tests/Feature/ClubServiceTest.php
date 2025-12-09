<?php

namespace Tests\Feature;

use App\Models\Club;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClubServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Dapat membuat club baru
     */
    public function test_can_create_club()
    {
        $clubData = [
            'name' => 'Test FC',
            'description' => 'This is a test club',
            'city' => 'Jakarta',
            'stadium' => 'Test Stadium',
            'founded_year' => 2020,
            'logo_url' => 'https://example.com/logo.png',
        ];

        $response = $this->postJson('/api/clubs', $clubData);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Club created successfully',
                     'data' => [
                         'name' => 'Test FC',
                         'city' => 'Jakarta',
                     ]
                 ]);

        $this->assertDatabaseHas('clubs', ['name' => 'Test FC']);
    }

    /**
     * Test: Tidak dapat membuat club tanpa nama
     */
    public function test_cannot_create_club_without_name()
    {
        $clubData = [
            'description' => 'This is a test club',
            'city' => 'Jakarta',
        ];

        $response = $this->postJson('/api/clubs', $clubData);

        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Validation error',
                 ])
                 ->assertJsonStructure([
                     'errors' => ['name']
                 ]);
    }

    /**
     * Test: Tidak dapat membuat club dengan nama duplikat
     */
    public function test_cannot_create_club_with_duplicate_name()
    {
        Club::create([
            'name' => 'Duplicate FC',
            'city' => 'Jakarta',
        ]);

        $response = $this->postJson('/api/clubs', [
            'name' => 'Duplicate FC',
            'city' => 'Bandung',
        ]);

        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Validation error',
                 ]);
    }

    /**
     * Test: Dapat mengambil semua clubs
     */
    public function test_can_get_all_clubs()
    {
        Club::create(['name' => 'Club A', 'city' => 'Jakarta']);
        Club::create(['name' => 'Club B', 'city' => 'Bandung']);
        Club::create(['name' => 'Club C', 'city' => 'Surabaya']);

        $response = $this->getJson('/api/clubs');

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Clubs retrieved successfully',
                 ])
                 ->assertJsonCount(3, 'data');
    }

    /**
     * Test: Dapat mengambil club berdasarkan ID
     */
    public function test_can_get_single_club()
    {
        $club = Club::create([
            'name' => 'Single Club',
            'city' => 'Malang',
            'stadium' => 'Test Stadium',
        ]);

        $response = $this->getJson('/api/clubs/' . $club->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Club retrieved successfully',
                     'data' => [
                         'id' => $club->id,
                         'name' => 'Single Club',
                         'city' => 'Malang',
                     ]
                 ]);
    }

    /**
     * Test: Mendapat 404 jika club tidak ditemukan
     */
    public function test_get_single_club_returns_404_if_not_found()
    {
        $response = $this->getJson('/api/clubs/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Club not found'
                 ]);
    }

    /**
     * Test: Dapat mengupdate club
     */
    public function test_can_update_club()
    {
        $club = Club::create([
            'name' => 'Original Name',
            'city' => 'Jakarta',
        ]);

        $response = $this->putJson('/api/clubs/' . $club->id, [
            'name' => 'Updated Name',
            'city' => 'Bandung',
            'stadium' => 'New Stadium',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Club updated successfully',
                     'data' => [
                         'name' => 'Updated Name',
                         'city' => 'Bandung',
                         'stadium' => 'New Stadium',
                     ]
                 ]);

        $this->assertDatabaseHas('clubs', ['name' => 'Updated Name']);
    }

    /**
     * Test: Tidak dapat mengupdate club yang tidak ada
     */
    public function test_cannot_update_nonexistent_club()
    {
        $response = $this->putJson('/api/clubs/999', [
            'name' => 'Test Name'
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Club not found'
                 ]);
    }

    /**
     * Test: Dapat menghapus club
     */
    public function test_can_delete_club()
    {
        $club = Club::create([
            'name' => 'To Be Deleted',
            'city' => 'Jakarta',
        ]);

        $response = $this->deleteJson('/api/clubs/' . $club->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Club deleted successfully'
                 ]);

        $this->assertDatabaseMissing('clubs', ['id' => $club->id]);
    }

    /**
     * Test: Tidak dapat menghapus club yang tidak ada
     */
    public function test_delete_nonexistent_club_returns_404()
    {
        $response = $this->deleteJson('/api/clubs/555');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Club not found'
                 ]);
    }

    /**
     * Test: Response mengandung Correlation ID header
     */
    public function test_response_contains_correlation_id_header()
    {
        $response = $this->getJson('/api/clubs');

        $response->assertHeader('X-Correlation-ID');
    }

    /**
     * Test: Correlation ID dari request diteruskan ke response
     */
    public function test_correlation_id_from_request_is_forwarded()
    {
        $correlationId = 'test-correlation-id-12345';

        $response = $this->withHeader('X-Correlation-ID', $correlationId)
                         ->getJson('/api/clubs');

        $response->assertHeader('X-Correlation-ID', $correlationId);
    }
}

