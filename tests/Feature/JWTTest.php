<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JWTTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_register_user(): void
    {
        $response = $this->post('/api/auth/register', [
            'name' => '木下次郎',
            'email' => 'kinoshita@aaa.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);

        $response->assertStatus(201);
    }

    public function test_login_user(): void
    {
        $registeredResponse = $this->post('/api/auth/register', [
            'name' => '木下次郎',
            'email' => 'kinoshita@aaa.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);
        $response = $this->post('/api/auth/login', [
            'email' => 'kinoshita@aaa.com',
            'password' => 'pass123',
        ]);
        $response->assertStatus(200);
    }

    public function test_me_user(): void
    {
        $registeredResponse = $this->post('/api/auth/register', [
            'name' => '木下次郎',
            'email' => 'kinoshita@aaa.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);
        $response = $this->post('/api/auth/login', [
            'email' => 'kinoshita@aaa.com',
            'password' => 'pass123',
        ]);

        $token = $response->json('access_token');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/auth/me');
        $response->assertStatus(200);
    }

    public function test_logout_user(): void
    {
        $registeredResponse = $this->post('/api/auth/register', [
            'name' => '木下次郎',
            'email' => 'kinoshita@aaa.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);

        $loginResponse = $this->post('/api/auth/login', [
            'email' => 'kinoshita@aaa.com',
            'password' => 'pass123',
        ]);

        $logoutResponse = $this->post('/api/auth/logout');
        $logoutResponse->assertStatus(200);
    }
}
