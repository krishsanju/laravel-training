<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister()
    {
        $data = [
            'name' => 'Keerthana',
            'email' => 'keerthana@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
            'token',
        ]);
    }


        public function testRegisterMissingFields()
    {
        $data =[
            'name' => 'Keerthana',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');

        $data =[
            'name' => 'Keerthana',
            'email' => 'keerthana@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);


        $data =[
            'name' => 'Keerthana',
            'email' => 'keerthana@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $data =[
            'name' => 'Keerthana',
            'email' => 'keerthana@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);



    }
}
