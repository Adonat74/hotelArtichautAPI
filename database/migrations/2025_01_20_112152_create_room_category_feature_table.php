<?php

use App\Models\RoomsCategory;
use App\Models\RoomsFeature;
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
            $table->foreignIdFor(RoomsCategory::class)->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(RoomsFeature::class)->cascadeOnDelete()->cascadeOnUpdate();
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
