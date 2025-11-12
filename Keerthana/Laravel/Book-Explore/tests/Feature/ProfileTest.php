<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    // use DatabaseMigrations;

    public function test_user_can_view_their_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson('/api/profile');

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'data']);
    }

    public function test_unauthenticated_user_cannot_view_profile()
    {
        $response = $this->getJson('/api/profile');

        $response->assertStatus(401);
    }

    public function test_user_can_update_their_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $payload = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->putJson('/api/profile', $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message'=> "Profile updated successfully",
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_update_profile_fails_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $payload = [
            'name' => '',
            'email' => 'not-an-email',
        ];

        $response = $this->putJson('/api/profile', $payload);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function test_user_can_soft_delete_their_account()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->deleteJson('/api/profile');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Account deleted successfully']);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_user_can_view_their_action_logs()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        // Assume we have a log created for testing
        $user->actionLogs()->create([
            'action' => 'test_action',
            'details' => 'Performed test action',
        ]);

        $response = $this->getJson('/api/profile/activity');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'action', 'details', 'created_at']]
            ]);
    }

    public function test_unauthenticated_user_cannot_access_activity_logs()
    {
        $response = $this->getJson('/api/profile/activity');

        $response->assertStatus(401);
    }
}
