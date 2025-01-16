<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomsFeature>
 */
class RoomsFeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Tv', 'Wifi', 'Mini bar']), // Noms générés aléatoirement
            'description' => $this->faker->sentence(10),
        ];
    }
}
