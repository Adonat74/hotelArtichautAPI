<?php

    namespace Database\Factories;

    use App\Models\Room;
    use App\Models\RoomsCategory;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class RoomFactory extends Factory
    {
        protected $model = Room::class;

        public function definition(): array
        {
            $category = RoomsCategory::inRandomOrder()->first();
            return [
                'name' => $this->faker->company(),
                'number' => $this->faker->numberBetween(101, 399),
                'room_name' => $this->faker->lastName(),
                'description' => $this->faker->sentence(10),
                'display_order' => $this->faker->numberBetween(1, 20),
                'rooms_category_id' => $category->id,
            ];
        }

//        // Suivi des numéros utilisés pour chaque catégorie
//        protected static $usedNumbers = [
//            'StandardRooms' => [],
//            'DeluxeRooms' => [],
//            'SuiteRooms' => [],
//        ];
//
//        public function definition()
//        {
//            $standardRooms = range(101, 210);  // Un pool avec des plages de numéros (101 à 210)
//            $deluxeRooms = range(301, 340);     // Un autre pool pour les chambres Deluxe
//            $suiteRooms = range(350, 400);
//            $category = RoomsCategory::inRandomOrder()->first();
//
//            if (!$category) {
//                throw new \Exception("Veuillez créer des catégories avant de générer des chambres.");
//            }
//
//            // Déterminer le pool de numéros en fonction de la catégorie
//            $pool = [];
//            if ($category->name === 'StandardRooms') {
//                $pool = $standardRooms;
//            } elseif ($category->name === 'DeluxeRooms') {
//                $pool = $deluxeRooms;
//            } elseif ($category->name === 'SuiteRooms') {
//                $pool = $suiteRooms;
//            }
//
//            // Exclure les numéros déjà utilisés
//            $availableRooms = array_diff($pool, static::$usedNumbers[$category->name]);
//
//            if (empty($availableRooms)) {
//                throw new \Exception("Aucun numéro de chambre disponible pour la catégorie : {$category->name}");
//            }
//
//            // Choisir un numéro disponible et marquer comme utilisé
//            $roomNumber = $this->faker->randomElement($availableRooms);
//            static::$usedNumbers[$category->name][] = $roomNumber;
//
//            return [
//                'number' => $roomNumber,
//                'name' => $this->faker->lastName(),
//                'description' => $this->faker->sentence(10),
//                'rooms_category_id' => $category->id,
//            ];
//        }
//
//        public static function resetUsedNumbers()
//        {
//            self::$usedNumbers = [
//                'StandardRooms' => [],
//                'DeluxeRooms' => [],
//                'SuiteRooms' => [],
//            ];
//        }

    }
