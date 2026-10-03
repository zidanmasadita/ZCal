<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodEntry extends Model
{
    use HasFactory, \App\Traits\BelongsToUser;

    protected $fillable = [
        'user_id',
        'name',
        'portion',
        'calories',
        'protein',
        'carbs',
        'fat',
        'meal_time',
        'photo_path',
        'source',
        'idempotency_key',
        'eaten_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
