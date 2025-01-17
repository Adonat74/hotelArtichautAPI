<?php

namespace Database\Seeders;

use App\Models\RoomsFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomsFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name' => 'Tv', 'description' => 'Une télévision à écran plat avec une large sélection de chaînes locales et internationales, permettant aux clients de se détendre et de profiter de divertissements dans leur chambre.'],
            ['name' => 'Wifi', 'description' => 'Connexion Internet sans fil haut débit, accessible gratuitement dans la chambre, idéale pour travailler, naviguer sur le web ou diffuser du contenu en ligne.'],
            ['name' => 'Mini bar', 'description' => 'Un mini-réfrigérateur rempli de boissons fraîches et de collations, offrant aux clients un confort supplémentaire et des rafraîchissements à portée de main.'],
        ];

        foreach ($features as $feature) {
            RoomsFeature::create($feature);
        }
    }
}
