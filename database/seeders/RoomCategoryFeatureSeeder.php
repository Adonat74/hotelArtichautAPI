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
                DB::table('rooms_categories_features')->insert([
                    'rooms_category_id' => $category->id,
                    'rooms_feature_id' => $featureId,
                ]);
            }
        }
    }
}
