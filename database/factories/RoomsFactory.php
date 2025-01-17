<?php

    namespace Database\Factories;

    use App\Models\Rooms;
    use App\Models\RoomsCategory;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class RoomsFactory extends Factory
    {
        protected $model = Rooms::class;

        // Suivi des numéros utilisés pour chaque catégorie
        protected static $usedNumbers = [
            'StandardRooms' => [],
            'DeluxeRooms' => [],
            'SuiteRooms' => [],
        ];

        public function definition()
        {
            $standardRooms = range(101, 210);  // Un pool avec des plages de numéros (101 à 210)
            $deluxeRooms = range(301, 340);     // Un autre pool pour les chambres Deluxe
            $suiteRooms = range(350, 400);
            $category = RoomsCategory::inRandomOrder()->first();

            if (!$category) {
                throw new \Exception("Veuillez créer des catégories avant de générer des chambres.");
            }

            // Déterminer le pool de numéros en fonction de la catégorie
            $pool = [];
            if ($category->name === 'StandardRooms') {
                $pool = $standardRooms;
            } elseif ($category->name === 'DeluxeRooms') {
                $pool = $deluxeRooms;
            } elseif ($category->name === 'SuiteRooms') {
                $pool = $suiteRooms;
            }

            // Exclure les numéros déjà utilisés
            $availableRooms = array_diff($pool, static::$usedNumbers[$category->name]);

            if (empty($availableRooms)) {
                throw new \Exception("Aucun numéro de chambre disponible pour la catégorie : {$category->name}");
            }

            // Choisir un numéro disponible et marquer comme utilisé
            $roomNumber = $this->faker->randomElement($availableRooms);
            static::$usedNumbers[$category->name][] = $roomNumber;

            return [
                'number' => $roomNumber,
                'description' => $this->faker->sentence(10),
                'price_in_cents' => $this->faker->numberBetween(5000, 20000),
                'rooms_category_id' => $category->id,
            ];
        }

        public static function resetUsedNumbers()
        {
            self::$usedNumbers = [
                'StandardRooms' => [],
                'DeluxeRooms' => [],
                'SuiteRooms' => [],
            ];
        }

    }
