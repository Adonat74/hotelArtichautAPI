<?php

use App\Models\Language;
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
                $table->string('name', length: 50);
                $table->integer('number');
                $table->string('room_name');
                $table->string('description');
                $table->foreignIdFor(RoomsCategory::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();
                $table->string('display_order');
                $table->foreignIdFor(Language::class);
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
