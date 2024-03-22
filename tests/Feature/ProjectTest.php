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
    $team_1 = Team::factory()->create();
    $team_2 = Team::factory()->create();
    $project_1 = Project::factory()->for($team_1)->create();
    $project_2 = Project::factory()->for($team_2)->create();

    $response = $this->get('/api/projects');

    $response->assertStatus(200)->assertJsonFragment([
      'id' => $project_1->id,
      'team_id' => $project_1->team_id,
      'name' => $project_1->name,
    ])->assertJsonFragment([
      'id' => $project_2->id,
      'team_id' => $project_2->team_id,
      'name' => $project_2->name,
    ]);
  }

  public function test_created_project(): void
  {
    $team = Team::factory()->create();

    $response = $this->post('/api/projects', ['team_id' => $team->id, 'name' => 'New Project']);

    $response->assertStatus(201)->assertJsonFragment(['team_id' => $team->id, 'name' => 'New Project']);
  }

  public function test_update_project(): void
  {
    $team = Team::factory()->create();
    $project = Project::factory()->for($team)->create();

    $response = $this->put("/api/projects/{$project->id}", ['team_id' => $team->id, 'name' => 'Updated Project']);

    $response->assertStatus(200)->assertJsonFragment(['team_id' => $team->id, 'name' => 'Updated Project']);
  }

  public function test_delete_project(): void
  {
    $team = Team::factory()->create();
    $project = Project::factory()->for($team)->create();

    $response = $this->delete("/api/projects/{$project->id}");

    $response->assertStatus(204);
  }
}
