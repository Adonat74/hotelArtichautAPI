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
            'check_in' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+ 10 days'),
            'check_out' => $this->faker->dateTimeBetween($startDate = '+ 12 days', $endDate = '+ 50 days'),

            'total_price_in_cent' => $this->faker->numberBetween(10000, 1000000),
            'to_be_paid_in_cent' => $this->faker->numberBetween(10000, 1000000),
            'number_of_persons' => $this->faker->numberBetween(1, 4),
            'user_id' => $user->id,
        ];
    }
}
