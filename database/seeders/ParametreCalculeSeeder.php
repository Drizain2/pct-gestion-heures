<?php

namespace Database\Seeders;

use App\Models\ParametreCalcule;
use Illuminate\Database\Seeder;

class ParametreCalculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parametres = [
            [
                'niveau_complexite' => 'niveau_1',
                'description' => 'Contenus simple + quiz + evaluation',
                'coefficient_creation' => 8,
                'coefficient_mise_a_jour' => 4,
            ],
            [
                'niveau_complexite' => 'niveau_2',
                'description' => 'Niveau 1 + 25% activités interactives + quiz + evaluation',
                'coefficient_creation' => 15,
                'coefficient_mise_a_jour' => 7.5,
            ],
            [
                'niveau_complexite' => 'niveau_3',
                'description' => 'Serious games, simulation, haute qualité',
                'coefficient_creation' => 30,
                'coefficient_mise_a_jour' => 15,
            ],
        ];

        foreach ($parametres as $parametre) {
            ParametreCalcule::create($parametre);
        }
    }
}
