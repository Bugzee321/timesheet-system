<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testIndexReturnsProjects()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        Project::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/projects');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         'projects' => [
                             '*' => ['id', 'name', 'status']
                         ],
                         'meta' => ['current_page', 'last_page', 'per_page', 'total']
                     ]
                 ]);
    }

    public function testStoreCreatesProject()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $projectData = [
            'name' => 'New Project',
            'status' => 'active',
        ];

        $response = $this->postJson('/api/v1/projects', $projectData);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'project' => [
                             'name' => 'New Project',
                             'status' => 'active',
                         ]
                     ]
                 ]);

        $this->assertDatabaseHas('projects', $projectData);
    }

    public function testShowReturnsProject()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $project = Project::factory()->create();

        $response = $this->getJson("/api/v1/projects/{$project->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'project' => [
                             'id' => $project->id,
                             'name' => $project->name,
                             'status' => $project->status,
                         ]
                     ]
                 ]);
    }

    public function testUpdateModifiesProject()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $project = Project::factory()->create();

        $updateData = [
            'name' => 'Updated Project',
            'status' => 'inactive',
        ];

        $response = $this->putJson("/api/v1/projects/{$project->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'project' => [
                             'name' => 'Updated Project',
                             'status' => 'inactive',
                         ]
                     ]
                 ]);

        $this->assertDatabaseHas('projects', $updateData);
    }

    public function testDestroyDeletesProject()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $project = Project::factory()->create();

        $response = $this->deleteJson("/api/v1/projects/{$project->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Project deleted successfully',
                 ]);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
} 