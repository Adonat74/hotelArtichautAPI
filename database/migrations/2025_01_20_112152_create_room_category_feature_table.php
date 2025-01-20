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
        Schema::create('room_category_feature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rooms_categories_id')->constrained('rooms_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('rooms_features_id')->constrained('rooms_features')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_category_feature');
    }
};
