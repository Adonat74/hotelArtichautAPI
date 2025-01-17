<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Content::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle(),
            'title' => $this->faker->company(),
            'short_description' => $this->faker->realText(200, 2),
            'description' => $this->faker->realText(1000, 2),
            'landing_page_display' => $this->faker->boolean(50),
            'navbar_display' => $this->faker->boolean(50),
        ];
    }
}
