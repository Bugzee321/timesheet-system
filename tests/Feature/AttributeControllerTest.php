<?php

namespace Tests\Feature;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttributeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testIndexReturnsAttributes()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        Attribute::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/attributes');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'data' => [
                         'attributes' => [
                             '*' => ['id', 'name', 'type']
                         ],
                         'meta' => ['current_page', 'last_page', 'per_page', 'total']
                     ]
                 ]);
    }

    public function testStoreCreatesAttribute()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $attributeData = [
            'name' => 'New Attribute',
            'type' => 'text',
        ];

        $response = $this->postJson('/api/v1/attributes', $attributeData);

        $response->assertStatus(201)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'attribute' => [
                             'name' => 'New Attribute',
                             'type' => 'text',
                         ]
                     ]
                 ]);

        $this->assertDatabaseHas('attributes', $attributeData);
    }

    public function testShowReturnsAttribute()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $attribute = Attribute::factory()->create();

        $response = $this->getJson("/api/v1/attributes/{$attribute->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'attribute' => [
                             'id' => $attribute->id,
                             'name' => $attribute->name,
                             'type' => $attribute->type,
                         ]
                     ]
                 ]);
    }

    public function testUpdateModifiesAttribute()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $attribute = Attribute::factory()->create();

        $updateData = [
            'name' => 'Updated Attribute',
            'type' => 'number',
        ];

        $response = $this->putJson("/api/v1/attributes/{$attribute->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'data' => [
                         'attribute' => [
                             'name' => 'Updated Attribute',
                             'type' => 'number',
                         ]
                     ]
                 ]);

        $this->assertDatabaseHas('attributes', $updateData);
    }

    public function testDestroyDeletesAttribute()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $attribute = Attribute::factory()->create();

        $response = $this->deleteJson("/api/v1/attributes/{$attribute->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Attribute deleted successfully',
                 ]);

        $this->assertDatabaseMissing('attributes', ['id' => $attribute->id]);
    }
} 