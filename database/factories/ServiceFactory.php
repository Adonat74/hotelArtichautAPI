<?php


namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'title' => $this->faker->company(),
            'short_description' => $this->faker->realText(150, 2),
            'description' => $this->faker->realText(1000, 2),
            'link' => $this->faker->company(),
            'price_in_cent' => $this->faker->numberBetween(1000, 100000),
            'duration_in_day' => $this->faker->numberBetween(1, 7),
            'is_per_person' => $this->faker->boolean(75),
            'display_order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
