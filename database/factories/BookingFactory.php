<?php

namespace Database\Factories;

use App\Models\RoomsCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        return [
            'check_in' => fake()->dateTimeBetween($startDate = 'now', $endDate = '+ 10 days'),
            'check_out' => fake()->dateTimeBetween($startDate = '+ 12 days', $endDate = '+ 50 days'),
            'user_id' => $user->id,
        ];
    }
}
