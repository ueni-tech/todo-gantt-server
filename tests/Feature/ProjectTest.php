<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
  use RefreshDatabase;

  public function test_should_list_empty_project(): void
  {
    $response = $this->get('/api/projects');

    $response->assertStatus(200);
  }

  public function test_should_list_projects(): void
  {
    $project = Project::factory()->create();

    $response = $this->get('/api/projects');

    $response->assertStatus(200)->assertJsonFragment([
      'id' => $project->id,
      'team_id' => $project->team_id,
      'name' => $project->name,
    ]);
  }
}
