<?php

namespace Database\Seeders;

use App\Models\RoomsCategory;
use App\Models\RoomsFeature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomCategoryFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roomCategories = RoomsCategory::all();
        $roomFeatures = RoomsFeature::all();

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
