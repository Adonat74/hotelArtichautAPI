<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomCategoryFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roomCategories = \App\Models\RoomsCategory::all();
        $roomFeatures = \App\Models\RoomsFeature::all();

        foreach ($roomCategories as $category) {
            // Associez 1 à 5 fonctionnalités aléatoires à chaque catégorie
            $features = $roomFeatures->random(rand(1, 3))->pluck('id');
            foreach ($features as $featureId) {
                DB::table('room_category_feature')->insert([
                    'rooms_categories_id' => $category->id,
                    'rooms_features_id' => $featureId,
                ]);
            }
        }
    }
}
