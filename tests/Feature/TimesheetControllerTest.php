<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimesheetControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testIndexReturnsTimesheets()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        Timesheet::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/timesheets');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         'timesheets' => [
                             '*' => ['id', 'date', 'hours', 'task_name']
                         ],
                         'meta' => ['current_page', 'last_page', 'per_page', 'total']
                     ]
                 ]);
    }

    public function testStoreCreatesTimesheet()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $this->actingAs($user, 'api');

        $timesheetData = [
            'date' => now()->toDateString(),
            'hours' => 8,
            'task_name' => 'Development',
            'project_id' => $project->id,
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/v1/timesheets', $timesheetData);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'timesheet' => [
                             'task_name' => 'Development',
                             'hours' => 8,
                         ]
                     ]
                 ]);

        $this->assertDatabaseHas('timesheets', $timesheetData);
    }

    public function testShowReturnsTimesheet()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $timesheet = Timesheet::factory()->create();

        $response = $this->getJson("/api/v1/timesheets/{$timesheet->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'timesheet' => [
                             'id' => $timesheet->id,
                             'task_name' => $timesheet->task_name,
                         ]
                     ]
                 ]);
    }

    public function testUpdateModifiesTimesheet()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $timesheet = Timesheet::factory()->create();

        $updateData = [
            'task_name' => 'Updated Task',
            'hours' => 5,
        ];

        $response = $this->putJson("/api/v1/timesheets/{$timesheet->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'timesheet' => [
                             'task_name' => 'Updated Task',
                             'hours' => 5,
                         ]
                     ]
                 ]);

        $this->assertDatabaseHas('timesheets', $updateData);
    }

    public function testDestroyDeletesTimesheet()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $timesheet = Timesheet::factory()->create();

        $response = $this->deleteJson("/api/v1/timesheets/{$timesheet->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Timesheet deleted successfully',
                 ]);

        $this->assertDatabaseMissing('timesheets', ['id' => $timesheet->id]);
    }
} 