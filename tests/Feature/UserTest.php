<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_should_list_empty_users(): void
    {
      $response = $this->get('/api/users');
  
      $response->assertStatus(200);
    }
}
