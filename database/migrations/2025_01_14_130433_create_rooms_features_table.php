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
        Schema::create('rooms_features', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 50);
            $table->string('feature_name');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('rooms_features');
    }
};
