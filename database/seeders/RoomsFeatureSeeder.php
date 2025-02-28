<?php

namespace Database\Seeders;

use App\Models\RoomsFeature;
use Illuminate\Database\Seeder;

class RoomsFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name' => 'tv_fr', 'feature_name' => 'Tv', 'description' => 'Une télévision à écran plat avec une large sélection de chaînes locales et internationales, permettant aux clients de se détendre et de profiter de divertissements dans leur chambre.', 'display_order' => 1, 'language_id' => 1],
            ['name' => 'wifi_fr', 'feature_name' => 'Wifi', 'description' => 'Connexion Internet sans fil haut débit, accessible gratuitement dans la chambre, idéale pour travailler, naviguer sur le web ou diffuser du contenu en ligne.', 'display_order' => 2, 'language_id' => 1],
            ['name' => 'bar_fr', 'feature_name' => 'Mini bar', 'description' => 'Un mini-réfrigérateur rempli de boissons fraîches et de collations, offrant aux clients un confort supplémentaire et des rafraîchissements à portée de main.', 'display_order' => 3, 'language_id' => 1],
        ];

        foreach ($features as $feature) {
            RoomsFeature::create($feature);
        }
    }
}
