<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\FoodEntry;
use Laravel\Sanctum\Sanctum;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_requires_token()
    {
        $response = $this->postJson('/api/webhooks/agent/food-log', []);
        $response->assertStatus(401);
    }

    public function test_webhook_requires_food_log_write_ability()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['wrong-ability']);

        $response = $this->postJson('/api/webhooks/agent/food-log', [
            'idempotency_key' => '123',
            'food_name' => 'Nasi',
            'calories' => 100,
            'protein' => 1,
            'carbs' => 20,
            'fat' => 0,
            'meal_type' => 'snack',
            'eaten_at' => '2026-10-03T12:00:00+07:00',
            'source' => 'whatsapp'
        ]);
        
        $response->assertStatus(403);
    }

    public function test_webhook_creates_food_entry()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['food-log:write']);

        $response = $this->postJson('/api/webhooks/agent/food-log', [
            'idempotency_key' => 'unique-123',
            'food_name' => 'Nasi Goreng',
            'calories' => 400,
            'protein' => 12,
            'carbs' => 50,
            'fat' => 15,
            'meal_type' => 'lunch',
            'eaten_at' => '2026-10-03T12:00:00+07:00',
            'source' => 'whatsapp'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('food_entries', [
            'user_id' => $user->id,
            'idempotency_key' => 'unique-123',
            'name' => 'Nasi Goreng',
            'calories' => 400,
            'source' => 'whatsapp'
        ]);
    }

    public function test_webhook_idempotency()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['food-log:write']);

        $payload = [
            'idempotency_key' => 'unique-123',
            'food_name' => 'Nasi Goreng',
            'calories' => 400,
            'protein' => 12,
            'carbs' => 50,
            'fat' => 15,
            'meal_type' => 'lunch',
            'eaten_at' => '2026-10-03T12:00:00+07:00',
            'source' => 'whatsapp'
        ];

        $response1 = $this->postJson('/api/webhooks/agent/food-log', $payload);
        $response1->assertStatus(201);

        // Send exactly the same again
        $response2 = $this->postJson('/api/webhooks/agent/food-log', $payload);
        $response2->assertStatus(200); // Expecting 200 OK for duplicate
        
        $this->assertEquals($response1->json('id'), $response2->json('id'));
        
        $count = FoodEntry::withoutGlobalScope('user_id')->where('idempotency_key', 'unique-123')->count();
        $this->assertEquals(1, $count);
    }

    public function test_webhook_isolates_data_between_users()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        // User A creates an entry
        Sanctum::actingAs($userA, ['food-log:write']);
        $this->postJson('/api/webhooks/agent/food-log', [
            'idempotency_key' => 'shared-key',
            'food_name' => 'A food',
            'calories' => 100,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
            'meal_type' => 'snack',
            'eaten_at' => '2026-10-03T12:00:00+07:00',
            'source' => 'whatsapp'
        ])->assertStatus(201);

        // User B uses the SAME idempotency key. It should NOT be a duplicate, it should create a new one for User B.
        Sanctum::actingAs($userB, ['food-log:write']);
        $this->postJson('/api/webhooks/agent/food-log', [
            'idempotency_key' => 'shared-key',
            'food_name' => 'B food',
            'calories' => 200,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
            'meal_type' => 'snack',
            'eaten_at' => '2026-10-03T12:00:00+07:00',
            'source' => 'whatsapp'
        ])->assertStatus(201); // Created

        $count = FoodEntry::withoutGlobalScope('user_id')->where('idempotency_key', 'shared-key')->count();
        $this->assertEquals(2, $count);
    }

    public function test_webhook_ignores_user_id_in_payload()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        Sanctum::actingAs($userA, ['food-log:write']);

        $response = $this->postJson('/api/webhooks/agent/food-log', [
            'user_id' => $userB->id, // Malicious attempt to assign to userB
            'idempotency_key' => 'key-123',
            'food_name' => 'A food',
            'calories' => 100,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
            'meal_type' => 'snack',
            'eaten_at' => '2026-10-03T12:00:00+07:00',
            'source' => 'whatsapp'
        ]);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('food_entries', [
            'user_id' => $userA->id,
            'idempotency_key' => 'key-123'
        ]);

        $this->assertDatabaseMissing('food_entries', [
            'user_id' => $userB->id,
            'idempotency_key' => 'key-123'
        ]);
    }
}
