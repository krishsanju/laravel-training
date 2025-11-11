<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminControllerTest extends TestCase
{
    public function test_admin_can_access_users_list()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin, 'api')->get('api/admin/users');

        $response->assertStatus(200);
    }

    public function test_non_admin_users_cannot_access_users_list()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin, 'api')->get('api/admin/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_all_favorites()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $reponse = $this->actingAs($admin, 'api')->get('api/all-favorites');

        $reponse->assertStatus(200);
    }

    public function test_non_admin_users_cannot_access_all_favorites()
    {
        $admin = User::factory()->create();
        $admin->assignRole('user');

        $reponse = $this->actingAs($admin, 'api')->get('api/all-favorites');

        $reponse->assertStatus(403);
    }

    
}
