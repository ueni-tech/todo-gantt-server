<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_list_empty_task(): void
    {
        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
    }

    public function test_should_list_projects_with_task(): void
    {
        $team_1 = Team::factory()->create();
        $team_2 = Team::factory()->create();
        $project_1 = Project::factory()->for($team_1)->create();
        $project_2 = Project::factory()->for($team_2)->create();
        $task_1 = Task::factory()->completed()->for($project_1)->create();
        $task_2 = Task::factory()->uncompleted()->for($project_2)->create();

        $response = $this->get('/api/tasks');

        $response->assertStatus(200)->assertJsonFragment([
            'id' => $task_1->id,
            'project_id' => $task_1->project_id,
            'name' => $task_1->name,
            'note' => $task_1->note,
            'start_date' => $task_1->start_date,
            'end_date' => $task_1->end_date,
            'is_completed' => 1,
        ])->assertJsonFragment([
            'id' => $task_2->id,
            'project_id' => $task_2->project_id,
            'name' => $task_2->name,
            'note' => $task_2->note,
            'start_date' => $task_2->start_date,
            'end_date' => $task_2->end_date,
            'is_completed' => 0,
        ]);
    }

    public function test_created_task(): void
    {
        $team = Team::factory()->create();
        $project = Project::factory()->for($team)->create();
        $response = $this->post('/api/tasks', ['project_id' => $project->id, 'name' => 'New task', 'note' => 'New note', 'start_date' => '2021-01-01', 'end_date' => '2021-01-02', 'is_completed' => 0]);

        $response->assertStatus(201)->assertJsonFragment(['project_id' => $project->id, 'name' => 'New task', 'note' => 'New note', 'start_date' => '2021-01-01', 'end_date' => '2021-01-02', 'is_completed' => 0]);
    }

    public function test_update_task(): void
    {
        $team = Team::factory()->create();
        $project_1 = Project::factory()->for($team)->create();
        $project_2 = Project::factory()->for($team)->create();
        $task = Task::factory()->for($project_1)->create();

        $response = $this->put("/api/tasks/{$task->id}", ['name' => 'Updated Project', 'project_id' => $project_2->id, 'note' => 'Updated note', 'start_date' => '2021-01-02', 'end_date' => '2021-01-03', 'is_completed' => 1]);

        $response->assertStatus(200)->assertJsonFragment(['name' => 'Updated Project', 'project_id' => $project_2->id, 'note' => 'Updated note', 'start_date' => '2021-01-02', 'end_date' => '2021-01-03', 'is_completed' => 1]);
    }

    public function test_delete_task(): void
    {
        $team = Team::factory()->create();
        $project = Project::factory()->for($team)->create();
        $task = Task::factory()->for($project)->create();

        $response = $this->delete("/api/tasks/{$task->id}");

        $response->assertStatus(204);
    }
}
