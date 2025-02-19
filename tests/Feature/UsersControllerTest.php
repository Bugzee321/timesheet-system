<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testIndexReturnsUsers()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        User::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         'users' => [
                             '*' => ['id', 'full_name', 'email']
                         ],
                         'meta' => ['current_page', 'last_page', 'per_page', 'total']
                     ]
                 ]);
    }

    public function testStoreCreatesUser()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin, 'api');

        $userData = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $response = $this->postJson('/api/v1/users', $userData);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'user' => [
                             'full_name' => 'Jane Doe',
                             'email' => 'jane.doe@example.com',
                         ]
                     ]
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'jane.doe@example.com',
        ]);
    }

    public function testShowReturnsUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'user' => [
                             'id' => $user->id,
                             'full_name' => $user->full_name,
                             'email' => $user->email,
                         ]
                     ]
                 ]);
    }

    public function testUpdateModifiesUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $updateData = [
            'first_name' => 'Updated Name',
            'last_name' => 'Updated Last Name',
        ];

        $response = $this->putJson("/api/v1/users/{$user->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'user' => [
                             'full_name' => 'Updated Name Updated Last Name',
                         ]
                     ]
                 ]);

        $this->assertDatabaseHas('users', $updateData);
    }

    public function testDestroyDeletesUser()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin, 'api');

        $user = User::factory()->create();

        $response = $this->deleteJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User deleted successfully',
                 ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
} 