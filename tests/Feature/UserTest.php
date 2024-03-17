<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_should_list_empty_users(): void
    {
      $response = $this->get('/api/users');
  
      $response->assertStatus(200);
    }

    public function test_should_create_user(): void
    {
      $user = User::factory()->create();

      $response = $this->post('/api/users');

      $response->assertStatus(200)->assertJsonFragment([
        'name' => $user->name,
        'email' => $user->email,
        'password' => $user->password,
      ]);
    }
}
