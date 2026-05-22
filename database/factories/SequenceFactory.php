<?php

namespace Database\Factories;

use App\Models\Sequence;
use App\Models\Cours;
use Illuminate\Database\Eloquent\Factories\Factory;

class SequenceFactory extends Factory
{
    protected $model = Sequence::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Titres de séquences typiques (par défaut)
        $titres = [
            'Introduction',
            'Concepts de base',
            'Étude de cas',
            'Travaux pratiques',
            'Approfonfissement',
            'Projet appliqué',
            'Synthèse',
            'Évaluation',
            'Révisions',
            'Application pratique',
            'Théorie avancée',
            'Exercices corrigés',
            'Analyse critique',
            'Méthodologie',
            'Présentation des outils'
        ];

        return [
            'cours_id' => Cours::factory(), // Relation avec Cours (crée un cours si non spécifié)
            'titre' => $faker->randomElement($titres),
            'ordre' => $faker->unique()->numberBetween(1, 10), // Ordre unique entre 1 et 10
            'description' => $faker->paragraphs(2, true), // 2 paragraphes en français
        ];
    }

    // State pour une séquence spécifique (ex: "Introduction")
    public function introduction()
    {
        return $this->state([
            'titre' => 'Introduction',
            'ordre' => 1,
            'description' => 'Cette séquence présente les objectifs et le plan du cours. Elle permet aux étudiants de comprendre les attentes et les compétences à acquérir.',
        ]);
    }

    // State pour une séquence avec un ordre élevé (ex: dernière séquence)
    public function conclusion()
    {
        return $this->state([
            'titre' => 'Synthèse et Évaluation',
            'ordre' => 10,
            'description' => 'Récapitulatif des notions abordées et évaluation des compétences acquises.',
        ]);
    }

    // State pour une séquence avec un cours spécifique
    public function pourCours($coursId)
    {
        return $this->state([
            'cours_id' => $coursId,
        ]);
    }
}