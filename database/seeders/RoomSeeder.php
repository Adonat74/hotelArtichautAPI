<?php

    namespace Database\Seeders;

    use Database\Factories\RoomFactory;
    use Illuminate\Database\Seeder;
    use App\Models\Room;

    class RoomSeeder extends Seeder
    {
        public function run()
        {
            RoomFactory::resetUsedNumbers();  // Réinitialiser les numéros utilisés

            // Créer directement 32 chambres sans catégorisation
            Room::factory()->count(32)->create();
        }
    }
