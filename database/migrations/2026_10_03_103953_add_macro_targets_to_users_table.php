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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('target_protein')->default(150)->after('daily_calories');
            $table->integer('target_carbs')->default(200)->after('target_protein');
            $table->integer('target_fat')->default(60)->after('target_carbs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['target_protein', 'target_carbs', 'target_fat']);
        });
    }
};
