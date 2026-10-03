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
        Schema::table('food_entries', function (Blueprint $table) {
            $table->string('idempotency_key')->nullable()->unique()->after('id');
            $table->dateTimeTz('eaten_at')->nullable()->after('meal_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_entries', function (Blueprint $table) {
            $table->dropColumn(['idempotency_key', 'eaten_at']);
        });
    }
};
