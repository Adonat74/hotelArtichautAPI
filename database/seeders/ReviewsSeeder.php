<?php

namespace Database\Seeders;

use App\Models\RoomsFeature;
use Database\Factories\ReviewsFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReviewsFactory::new()->count(32)->create(); // Utilisation correcte de la factory
    }
}
