<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_to_register_a_user_and_receive_tokens()
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'te3@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $response = $this->postJson('/api/auth/register', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token',
            ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_register_fails_with_invalid_data(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => '123',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function test_it_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'secret123'
        ]);
        
        if (! Hash::check('secret123', $user->password)) {
            $user->update(['password' => bcrypt('secret123')]);
        }

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token',
            ]);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure(['error']);
    }

    public function test_it_can_refresh_token_using_refresh_token(): void
    {
        $registerPayload = [
            'name' => 'R User',
            'email' => 'refresh2@example.com',
            'password' => 'refreshpass',
            'password_confirmation' => 'refreshpass',
        ];

        $registerResponse = $this->postJson('/api/auth/register', $registerPayload);
        $registerResponse->assertStatus(200);

        $refreshToken = $registerResponse->json('refresh_token');

        $response = $this->postJson('/api/auth/refresh-token', [
            'refresh_token' => $refreshToken,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token',
            ]);
    }

    public function test_it_can_logout_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully']);
    }

    // public function test_forgot_password_sends_reset_notification(): void
    // {
    //     Notification::fake();

    //     $user = User::factory()->create();

    //     $response = $this->postJson('/api/auth/forgot-password', [
    //         'email' => $user->email,
    //     ]);

    //     $response->assertStatus(200)
    //         ->assertJson(['message' => 'Password reset link sent']);

    //     Notification::assertSentTo($user, ResetPassword::class);
    // }

    // public function test_user_can_reset_password_with_valid_token(): void
    // {
    //     $user = User::factory()->create();

    //     // Generate token using Password broker
    //     $token = Password::createToken($user);

    //     $newPassword = 'new-secret-123';

    //     $response = $this->postJson('/api/auth/reset-password', [
    //         'email' => $user->email,
    //         'token' => $token,
    //         'password' => $newPassword,
    //         'password_confirmation' => $newPassword,
    //     ]);

    //     $response->assertStatus(200)
    //         ->assertJson(['message' => 'Password has been reset']);

    //     $user->refresh();
    //     $this->assertTrue(Hash::check($newPassword, $user->password));
    // }

    // public function test_email_verification_endpoint_marks_email_as_verified(): void
    // {
    //     $user = User::factory()->unverified()->create();

    //     $hash = sha1($user->email);

    //     $response = $this->getJson("/api/auth/verify-email/{$user->id}/{$hash}");

    //     $response->assertStatus(200)
    //         ->assertJson(['message' => 'Email verified successfully']);

    //     $this->assertTrue($user->fresh()->hasVerifiedEmail());
    // }

    // public function test_resend_verification_sends_email(): void
    // {
    //     Notification::fake();

    //     $user = User::factory()->unverified()->create();

    //     $response = $this->postJson('/api/auth/resend-verification', [
    //         'email' => $user->email,
    //     ]);

    //     $response->assertStatus(200)
    //         ->assertJson(['message' => 'Verification email sent']);

    //     // cannot assert exact notification class if you use built-in; at least ensure something was sent
    //     Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);
    // }

    // public function test_delete_account_soft_deletes_user(): void
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user, 'api');

    //     $response = $this->deleteJson('/api/auth/delete');

    //     $response->assertStatus(200)
    //         ->assertJson(['message' => 'Account deleted successfully']);

    //     $this->assertSoftDeleted('users', ['id' => $user->id]);
    // }
}
