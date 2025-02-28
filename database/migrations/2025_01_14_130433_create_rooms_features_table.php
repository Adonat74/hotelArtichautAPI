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
        Schema::create('rooms_features', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 50);
            $table->String('feature_name');
            $table->string('description')->nullable();
            $table->string('display_order');
            $table->string('language_id');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms_features');
    }
};
