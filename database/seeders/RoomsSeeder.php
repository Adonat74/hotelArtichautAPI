<?php

    namespace Database\Seeders;

    use Database\Factories\RoomsFactory;
    use Illuminate\Database\Seeder;
    use App\Models\Rooms;

    class RoomsSeeder extends Seeder
    {
        public function run()
        {
            RoomsFactory::resetUsedNumbers();  // Réinitialiser les numéros utilisés

            // Créer directement 32 chambres sans catégorisation
            Rooms::factory()->count(32)->create();
        }
    }
