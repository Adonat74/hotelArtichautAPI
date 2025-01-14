<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateRoomsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up(): void
        {
            Schema::create('rooms', function (Blueprint $table) {
                $table->id('rooms_id');               // Définir la clé primaire
                $table->integer('number');
                $table->string('description');        // Description de la chambre
                $table->integer('price_in_cents');             // Prix de la chambre
                $table->timestamps();                 // Colonnes created_at et updated_at

                // Clé étrangère (FK) pour la table rooms_categories
                $table->unsignedBigInteger('fk_has_rooms_categories');
                $table->foreign('fk_has_rooms_categories')
                    ->references('rooms_categories_id')
                    ->on('rooms_categories')
                    ->onDelete('cascade');  // Supprimer en cascade si la catégorie est supprimée
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down(): void
        {
            Schema::dropIfExists('rooms');
        }
    }
