<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
  use RefreshDatabase;

  public function test_should_list_empty_users(): void
  {
    $response = $this->get('/api/users');

    $response->assertStatus(200);
  }

  public function test_should_list_users(): void
  {
    $user = User::factory()->create();

    $response = $this->get('/api/users');

    $response->assertStatus(200)->assertJsonFragment([
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
    ]);
  }

  public function test_delete_user(): void
  {
    $user = User::factory()->create();

    $response = $this->delete("/api/users/{$user->id}");

    $response->assertStatus(200)->assertJsonFragment([
      'message' => 'User deleted successfully'
    ]);
  }
}
