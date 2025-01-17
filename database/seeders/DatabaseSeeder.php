<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            ContentSeeder::class,
            NewsArticleSeeder::class,
            ServiceSeeder::class,
            RoomsCategorySeeder::class,
            RoomSeeder::class,
            RoomsFeatureSeeder::class,
            ReviewSeeder::class,
            RoomCategoryFeatureSeeder::class,
        ]);


    }
}
