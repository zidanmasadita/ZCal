<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\FoodEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function museAi(Request $request)
    {
        $user = $request->user();

        if (!$user->currentAccessToken()->can('food-log:write')) {
            return response()->json(['error' => 'Forbidden: Token lacks food-log:write ability'], 403);
        }

        $validated = $request->validate([
            'idempotency_key' => 'required|string|max:100',
            'food_name' => 'required|string|max:255',
            'calories' => 'required|integer|min:0|max:10000',
            'protein' => 'required|numeric|min:0|max:1000',
            'carbs' => 'required|numeric|min:0|max:1000',
            'fat' => 'required|numeric|min:0|max:1000',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'eaten_at' => 'required|date',
            'source' => 'required|in:whatsapp,manual,api',
        ]);

        // Idempotency Check
        $existingEntry = FoodEntry::withoutGlobalScope('user_id')
            ->where('idempotency_key', $validated['idempotency_key'])
            ->where('user_id', $user->id)
            ->first();

        if ($existingEntry) {
            return response()->json([
                'id' => $existingEntry->id,
                'status' => 'duplicate',
            ], 200);
        }
        
        $entry = FoodEntry::create([
            'user_id' => $user->id,
            'idempotency_key' => $validated['idempotency_key'],
            'name' => $validated['food_name'],
            'calories' => $validated['calories'],
            'protein' => $validated['protein'],
            'carbs' => $validated['carbs'],
            'fat' => $validated['fat'],
            'meal_time' => ucfirst($validated['meal_type']),
            'eaten_at' => Carbon::parse($validated['eaten_at']),
            'source' => $validated['source'],
        ]);

        $token = $user->currentAccessToken();
        if ($token instanceof \Laravel\Sanctum\PersonalAccessToken) {
            $token->forceFill(['last_used_at' => now()])->save();
        }

        return response()->json([
            'id' => $entry->id,
            'status' => 'created'
        ], 201);
    }
}
