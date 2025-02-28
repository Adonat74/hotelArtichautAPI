<?php

namespace Database\Seeders;

use Database\Factories\ReviewFactory;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReviewFactory::new()
            ->count(32)
            ->create(); // Utilisation correcte de la factory
    }
}
