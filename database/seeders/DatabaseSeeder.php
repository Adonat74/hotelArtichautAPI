<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

//        UserController::factory()->create([
//            'name' => 'Test UserController',
//            'email' => 'test@example.com',
//        ]);

        $this->call([
            ContentSeeder::class,
            NewsArticleSeeder::class,
            ServiceSeeder::class,
            RoomsCategorySeeder::class,
            RoomSeeder::class,
            RoomsFeatureSeeder::class,
            ReviewSeeder::class,
            RoomCategoryFeatureSeeder::class,
            LanguageSeeder::class,
            UserSeeder::class,
        ]);


    }
}
