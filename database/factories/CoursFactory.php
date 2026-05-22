<?php

namespace Database\Factories;

use App\Models\Cours;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoursFactory extends Factory
{
    protected $model = Cours::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Filières typiques (adaptables)
        $filieres = [
            'Informatique', 'Mathématiques', 'Physique-Chimie', 'Biologie',
            'Économie et Gestion', 'Droit', 'Sciences Sociales', 'Lettres Modernes',
            'Anglais', 'Comptabilité', 'Finance', 'Marketing'
        ];

        // Niveaux (Licence/Master/Doctorat)
        $niveaux = ["L1", "L2", "L3", "M1", "M2"];

        // Semestres
        $semestres = ["S1", "S2", "S3", "S4", "S5","S6","S7","S8","S9","S10" ];

        // Intitulés de cours (exemples)
        $intitules = [
            'Algorithmique et Programmation',
            'Bases de Données',
            'Mathématiques Discrètes',
            'Économie Générale',
            'Droit des Affaires',
            'Comptabilité Analytique',
            'Réseaux et Télécommunications',
            'Intelligence Artificielle',
            'Marketing Digital',
            'Gestion des Projets',
            'Statistiques Appliquées',
            'Théorie des Organisations',
            'Langue Anglaise Technique',
            'Chimie Organique',
            'Physique Quantique'
        ];

        return [
            'intitule' => $faker->randomElement($intitules),
            'filiere' => $faker->randomElement($filieres),
            'niveau' => $faker->randomElement($niveaux),
            'semestre' => $faker->randomElement($semestres),
            'nombre_heures' => $faker->randomElement([30, 45, 60, 75, 90]), // Heures par semestre
            'nombre_credits' => $faker->randomElement([2, 3, 4, 5, 6]), // Crédits ECTS
        ];
    }

    // State pour une filière spécifique
    public function filiereInformatique()
    {
        return $this->state([
            'filiere' => 'Informatique',
            'intitule' => $this->faker->randomElement([
                'Algorithmique et Programmation',
                'Bases de Données',
                'Réseaux et Télécommunications',
                'Intelligence Artificielle',
                'Développement Web',
                'Structures de Données'
            ]),
        ]);
    }

    // State pour un niveau spécifique (ex: Licence 3)
    public function licence3()
    {
        return $this->state([
            'niveau' => 'L3',
            'nombre_credits' => $this->faker->randomElement([4, 5, 6]),
        ]);
    }

    // State pour un cours avec beaucoup d'heures
    public function coursIntensif()
    {
        return $this->state([
            'nombre_heures' => 90,
            'nombre_credits' => 6,
        ]);
    }
}