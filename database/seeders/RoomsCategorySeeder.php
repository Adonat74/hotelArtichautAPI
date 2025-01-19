<?php

    namespace Database\Seeders;

    use App\Models\RoomsCategory;
    use Illuminate\Database\Seeder;

    class RoomsCategorySeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            // Crée des catégories prédéfinies
            $categories = [
                ['name' => 'StandardRooms', 'description' => 'Spacious room with a great view.', 'price_in_cent' => 100000, 'bed_size' => 70],  // Prix en centimes
                ['name' => 'DeluxeRooms', 'description' => 'Luxurious room with premium amenities.', 'price_in_cent' => 200000, 'bed_size' => 100],
                ['name' => 'SuiteRooms', 'description' => 'A suite with a living area and bedroom.', 'price_in_cent' => 300000, 'bed_size' => 120],
            ];

            foreach ($categories as $category) {
                RoomsCategory::create($category);
            }
        }
    }
