<?php

use App\Models\Language;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 50);
            $table->string('title', length: 50);
            $table->string('short_description', length: 150);
            $table->string('description', length: 1000);
            $table->string('link', length: 50);
            $table->integer('price_in_cent');
            $table->integer('duration_in_day');
            $table->boolean('is_per_person');
            $table->string('display_order');
            $table->foreignIdFor(Language::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
