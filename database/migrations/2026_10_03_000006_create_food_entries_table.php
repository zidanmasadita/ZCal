<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('food_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('portion')->nullable();
            $table->integer('calories');
            $table->integer('protein')->nullable();
            $table->integer('carbs')->nullable();
            $table->integer('fat')->nullable();
            $table->string('meal_time')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('source')->nullable(); // misal: WhatsApp, Manual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_entries');
    }
};
