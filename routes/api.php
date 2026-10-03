<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/webhooks/agent/food-log', [\App\Http\Controllers\Api\WebhookController::class, 'museAi'])->middleware('auth:sanctum');
