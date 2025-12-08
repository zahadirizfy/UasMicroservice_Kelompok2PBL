<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticatedUserServiceTest extends TestCase
{
    use RefreshDatabase;

    /** Authenticate using NON-persisted user (avoids polluting database) */
    private function auth()
    {
        Sanctum::actingAs(
            User::factory()->make(), // make() = tidak masuk database
            ['*']
        );
    }

    public function test_can_create_user()
    {
        $this->auth();

        $response = $this->postJson('/api/users', [
            'name' => 'Alice',
            'email' => 'alice@mail.com',
            'password' => 'secret123'
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Alice',
                     'email' => 'alice@mail.com'
                 ]);

        $this->assertDatabaseHas('users', ['email' => 'alice@mail.com']);
    }

    public function test_cannot_create_user_with_invalid_email()
    {
        $this->auth();

        $response = $this->postJson('/api/users', [
            'name' => 'Bob',
            'email' => 'invalid-email',
            'password' => 'secret123'
        ]);

        $response->assertStatus(422);
    }

    public function test_can_get_all_users()
    {
        $this->auth();

        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_get_single_user()
    {
        $this->auth();

        $user = User::factory()->create();

        $response = $this->getJson('/api/users/' . $user->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id
                 ]);
    }

    public function test_get_single_user_returns_404_if_not_found()
    {
        $this->auth();

        $response = $this->getJson('/api/users/9999');

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'User not found'
                 ]);
    }

    public function test_can_update_user()
    {
        $this->auth();

        $user = User::factory()->create();

        $response = $this->putJson('/api/users/' . $user->id, [
            'name' => 'Updated Name',
            'email' => 'updated@mail.com'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Updated Name',
                     'email' => 'updated@mail.com'
                 ]);

        $this->assertDatabaseHas('users', ['email' => 'updated@mail.com']);
    }

    public function test_cannot_update_nonexistent_user()
    {
        $this->auth();

        $response = $this->putJson('/api/users/999', [
            'name' => 'Test'
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'User not found'
                 ]);
    }

    public function test_can_delete_user()
    {
        $this->auth();

        $user = User::factory()->create();

        $response = $this->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'User deleted'
                 ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_delete_nonexistent_user_returns_404()
    {
        $this->auth();

        $response = $this->deleteJson('/api/users/555');

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'User not found'
                 ]);
    }
}
