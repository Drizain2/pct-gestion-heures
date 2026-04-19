<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParametreCalcule;

class ParametreCalculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parametres = [
            [
                "niveau_complexite" => "niveau_1",
                "description" => "Contenus simple + quiz + evaluation",
                "coefficient_creation" => 0.40,
                "coefficient_mise_a_jour" => 0.20
            ],
            [
                "niveau_complexite" => "niveau_2",
                "description" => "Niveau 1 + 25% activités interactives + quiz + evaluation",
                "coefficient_creation" => 0.75,
                "coefficient_mise_a_jour" => 0.375
            ],
            [
                "niveau_complexite" => "niveau_3",
                "description" => "Serious games, simulation, haute qualité",
                "coefficient_creation" => 1.5,
                "coefficient_mise_a_jour" => 0.75
            ],
        ];

        foreach ($parametres as $parametre) {
            ParametreCalcule::create($parametre);
        }
    }
}
