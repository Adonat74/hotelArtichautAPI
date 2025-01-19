<?php

use App\Models\Content;
use App\Models\NewsArticle;
use App\Models\Room;
use App\Models\RoomsCategory;
use App\Models\Service;
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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->foreignIdFor(Content::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(NewsArticle::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Service::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(RoomsCategory::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Room::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
