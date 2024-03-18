<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Team;
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

  public function test_should_list_projects_with_team(): void
  {
    $team = Team::factory()->create();
    $project = Project::factory()->for($team)->create();

    $response = $this->get('/api/projects');

    $response->assertStatus(200)->assertJsonFragment([
      'id' => $project->id,
      'team_id' => $team->id,
      'name' => $project->name,
    ]);
  }
}
