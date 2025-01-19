<?php

use App\Models\RoomsCategory;
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
                $table->id();               // Définir la clé primaire
                $table->integer('number');
                $table->string('name');
                $table->string('description');
                $table->foreignIdFor(RoomsCategory::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();
// Description de la chambre
                $table->timestamps();                 // Colonnes created_at et updated_at

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
