<?php

use App\Models\Content;
use App\Models\NewsArticle;
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
            $table->id('image_id');
            $table->string('url');
            $table->foreignId('fk_content_id')->nullable()->constrained('contents', 'content_id')->onDelete('cascade');
            $table->foreignId('fk_news_article_id')->nullable()->constrained('news_articles', 'news_article_id')->onDelete('cascade');
            $table->foreignId('fk_service_id')->nullable()->constrained('services', 'service_id')->onDelete('cascade');
//            $table->foreignIdFor('fk_rooms_category_id');
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
