<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

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
            RoleSeeder::class,
            BookingSeeder::class,
            PaymentSeeder::class,
            BookingRoomSeeder::class,
            BookingServiceSeeder::class,
        ]);
    }
}
