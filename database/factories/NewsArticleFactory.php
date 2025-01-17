<?php


namespace Database\Factories;

use App\Models\NewsArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsArticle>
 */
class NewsArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = NewsArticle::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->catchPhrase,
            'short_description' => $this->faker->realText(200, 2),
            'description' => $this->faker->realText(1000, 2),
        ];
    }
}
