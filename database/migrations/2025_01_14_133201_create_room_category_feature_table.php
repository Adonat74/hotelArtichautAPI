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
                $table->unsignedBigInteger('rooms_categories_id');
                $table->unsignedBigInteger('feature_id');

                // Définition des clés étrangères
                $table->foreign('rooms_categories_id')
                    ->references('id')
                    ->on('rooms_categories')
                    ->onDelete('cascade');

                $table->foreign('feature_id')
                    ->references('id')
                    ->on('features')
                    ->onDelete('cascade');

                $table->unique(['rooms_categories_id', 'feature_id']); // Contrainte d'unicité
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
