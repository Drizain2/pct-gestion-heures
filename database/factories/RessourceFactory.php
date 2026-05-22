<?php

namespace Database\Factories;

use App\Models\Ressource;
use App\Models\Sequence;
use App\Models\Enseignant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RessourceFactory extends Factory
{
    protected $model = Ressource::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Types de ressources (selon ton modèle)
        $types = [
            'contenu_textuel',
            'video',
            'document',
            'quiz',
            'activite_interactive',
            'evaluation'
        ];

        // Niveaux de complexité (selon ton modèle)
        $complexites = [
            'niveau_1',
            'niveau_2',
            'niveau_3'
        ];

        // Titres de ressources par type
        $titresParType = [
            'contenu_textuel' => [
                'Cours théorique : {topic}',
                'Résumé du chapitre {number}',
                'Fiche de révision : {topic}',
                'Explications détaillées sur {topic}',
                'Notions clés à retenir'
            ],
            'video' => [
                'Tutoriel vidéo : {topic}',
                'Cours en vidéo - {topic}',
                'Démonstration pratique : {topic}',
                'Conférence : {topic}',
                'Webinaire sur {topic}'
            ],
            'document' => [
                'PDF : {topic}',
                'Support de cours - {topic}',
                'Exercices corrigés : {topic}',
                'Polycopié du chapitre {number}',
                'Article scientifique : {topic}'
            ],
            'quiz' => [
                'QCM : {topic}',
                'Quiz de révision - {topic}',
                'Évaluation formative : {topic}',
                'Test de connaissances : {topic}',
                'Auto-évaluation : {topic}'
            ],
            'activite_interactive' => [
                'Atelier pratique : {topic}',
                'Simulation : {topic}',
                'Jeu sérieux : {topic}',
                'Étude de cas interactive : {topic}',
                'Laboratoire virtuel : {topic}'
            ],
            'evaluation' => [
                'Devoir surveillé : {topic}',
                'Partiel - {topic}',
                'Examen final : {topic}',
                'Projet noté : {topic}',
                'Évaluation sommative : {topic}'
            ]
        ];

        // Topics génériques pour remplacer {topic}
        $topics = [
            'Algorithmique', 'Bases de données', 'Programmation orientée objet',
            'Réseaux informatiques', 'Sécurité des systèmes', 'Intelligence artificielle',
            'Mathématiques appliquées', 'Gestion de projet', 'Marketing digital',
            'Comptabilité', 'Droit des affaires', 'Économie générale'
        ];

        // Choisir un type aléatoire
        $type = $faker->randomElement($types);

        // Générer un titre dynamique
        $titreTemplate = $faker->randomElement($titresParType[$type]);
        $titre = str_replace(
            ['{topic}', '{number}'],
            [$faker->randomElement($topics), $faker->numberBetween(1, 10)],
            $titreTemplate
        );

        return [
            'sequence_id' => Sequence::factory(), // Crée une séquence si non spécifié
            'enseignant_id' => Enseignant::factory(), // Crée un enseignant si non spécifié
            'titre' => $titre,
            'type' => $type,
            'complexite' => $faker->randomElement($complexites),
            'description' => $faker->paragraphs(2, true), // 2 paragraphes en français
        ];
    }

    // State pour un type spécifique
    public function contenuTextuel()
    {
        return $this->state([
            'type' => 'contenu_textuel',
            'complexite' => 'niveau_1',
        ]);
    }

    public function video()
    {
        return $this->state([
            'type' => 'video',
            'complexite' => 'niveau_2',
        ]);
    }

    public function quiz()
    {
        return $this->state([
            'type' => 'quiz',
            'complexite' => 'niveau_1',
        ]);
    }

    public function evaluation()
    {
        return $this->state([
            'type' => 'evaluation',
            'complexite' => 'niveau_3',
        ]);
    }

    // State pour une complexité spécifique
    public function niveau1()
    {
        return $this->state([
            'complexite' => 'niveau_1',
        ]);
    }

    public function niveau3()
    {
        return $this->state([
            'complexite' => 'niveau_3',
        ]);
    }

    // State pour lier à une séquence ou un enseignant existant
    public function pourSequence($sequenceId)
    {
        return $this->state([
            'sequence_id' => $sequenceId,
        ]);
    }

    public function pourEnseignant($enseignantId)
    {
        return $this->state([
            'enseignant_id' => $enseignantId,
        ]);
    }
}