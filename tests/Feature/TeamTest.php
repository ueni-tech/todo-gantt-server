<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_list_empty_teams(): void
    {
        $this->get('/api/teams')->assertStatus(200);
    }

    public function test_should_list_teams(): void
    {
        $team_1 = Team::factory()->create();
        $team_2 = Team::factory()->create();
        $team_3 = Team::factory()->create();

        $this->get('/api/teams')->assertStatus(200)
            ->assertJsonFragment(['id' => $team_1->id, 'name' => $team_1->name])
            ->assertJsonFragment(['id' => $team_2->id, 'name' => $team_2->name])
            ->assertJsonFragment(['id' => $team_3->id, 'name' => $team_3->name]);
    }

    public function test_created_team(): void
    {
        $this->post('/api/teams', ['name' => 'New Team'])->assertStatus(201)
            ->assertJsonFragment(['name' => 'New Team']);
    }

    public function test_update_team(): void
    {
        $team = Team::factory()->create();

        $this->put("/api/teams/{$team->id}", ['name' => 'Updated Team'])->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Team']);
    }

    public function test_delete_todo(): void
    {
        $team = Team::factory()->create();

        $this->delete("/api/teams/{$team->id}")->assertStatus(204);
    }
}