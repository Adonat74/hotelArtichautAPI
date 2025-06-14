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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 50);
            $table->string('title', length: 50);
            $table->string('short_description');
            $table->text('description');
            $table->boolean('landing_page_display');
            $table->boolean('navbar_display');
            $table->string('link')->nullable();
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
        Schema::dropIfExists('contents');
    }
};
