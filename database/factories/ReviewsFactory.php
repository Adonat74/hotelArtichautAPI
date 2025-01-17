<?php

    namespace Database\Factories;

    use App\Models\Reviews;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class ReviewsFactory extends Factory
    {
        protected $model = Reviews::class;

        public function definition(): array
        {
            return [
                'rate' => $this->faker->numberBetween(1, 5), // Note aléatoire entre 1 et 5
                'review_content' => $this->faker->sentence(15), // Contenu de l'avis aléatoire
                'user_id' => $this->faker->numberBetween(1, 100), // ID utilisateur aléatoire
            ];
        }
    }
