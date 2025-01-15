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


                $table->foreignIdFor(\App\Models\RoomsCategory::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();
                $table->foreignIdFor(\App\Models\RoomsFeature::class)->nullable()->cascadesOnDelete()->cascadeOnUpdate();

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
