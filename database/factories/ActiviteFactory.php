<?php

namespace Database\Factories;

use App\Models\Activite;
use App\Models\Enseignant;
use App\Models\Cours;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActiviteFactory extends Factory
{
    protected $model = Activite::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Types d'actions possibles
        $typeActions = ['creation', 'mise_a_jour'];

        // Statuts possibles
        $statuts = ['en_attente', 'validee', 'rejetee'];

        // Complexités (mêmes que pour Ressource)
        $complexites = ['niveau_1', 'niveau_2', 'niveau_3'];

        // Commentaires typiques
        $commentaires = [
            'Création de nouvelles séquences pour le cours.',
            'Mise à jour des ressources existantes.',
            'Ajout de contenus pédagogiques supplémentaires.',
            'Correction des erreurs dans les activités précédentes.',
            'Préparation des évaluations pour le semestre.',
            'Adaptation du cours aux nouveaux standards.',
            'Intégration de feedbacks étudiants.',
            'Optimisation des temps de charge.',
        ];

        // Date d'activité : entre -1 mois et +1 mois
        $dateActivite = $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d');

        // Heures calculées : entre 10 et 100 (adaptable)
        $heuresCalculees = $faker->numberBetween(10, 100);

        // Nombre de séquences : entre 1 et 10
        $nbSequences = $faker->numberBetween(1, 10);

        return [
            'enseignant_id' => Enseignant::factory(),
            'cours_id' => Cours::factory(),
            'nb_sequences' => $nbSequences,
            'complexite' => $faker->randomElement($complexites),
            'type_action' => $faker->randomElement($typeActions),
            'heures_calculees' => $heuresCalculees,
            'date_activite' => $dateActivite,
            'commentaire' => $faker->randomElement($commentaires),
            'statut' => $faker->randomElement($statuts),
            'validee_par' => User::factory(), // Crée un utilisateur si non spécifié
            'validee_le' => $faker->optional(0.7)->dateTimeThisMonth(), // 70% de chance d'avoir une date de validation
        ];
    }

    // State pour une activité validée
    public function validee()
    {
        return $this->state([
            'statut' => 'validee',
            'validee_le' => now(),
            'validee_par' => User::factory(), // ou un ID spécifique
        ]);
    }

    // State pour une activité en attente
    public function enAttente()
    {
        return $this->state([
            'statut' => 'en_attente',
            'validee_par' => null,
            'validee_le' => null,
        ]);
    }

    // State pour une activité rejetée
    public function rejetee()
    {
        return $this->state([
            'statut' => 'rejetee',
            'commentaire' => $this->faker->randomElement([
                'Activité non conforme aux attentes.',
                'Manque de détails dans la description.',
                'Heures calculées non justifiées.',
                'À refaire selon les commentaires.',
            ]),
            'validee_le' => now(),
            'validee_par' => User::factory(),
        ]);
    }

    // State pour une activité de création
    public function creation()
    {
        return $this->state([
            'type_action' => 'creation',
            'commentaire' => $this->faker->randomElement([
                'Création de nouvelles séquences pour le cours.',
                'Ajout de ressources pédagogiques.',
                'Nouvelle activité planifiée.',
            ]),
        ]);
    }

    // State pour une activité de mise à jour
    public function miseAJour()
    {
        return $this->state([
            'type_action' => 'mise_a_jour',
            'commentaire' => $this->faker->randomElement([
                'Mise à jour des séquences existantes.',
                'Correction des erreurs dans les ressources.',
                'Actualisation des contenus.',
            ]),
        ]);
    }

    // State pour une complexité spécifique
    public function niveau1()
    {
        return $this->state([
            'complexite' => 'niveau_1',
            'heures_calculees' => $this->faker->numberBetween(10, 30),
        ]);
    }

    public function niveau3()
    {
        return $this->state([
            'complexite' => 'niveau_3',
            'heures_calculees' => $this->faker->numberBetween(50, 100),
        ]);
    }

    // State pour lier à un enseignant ou un cours existant
    public function pourEnseignant($enseignantId)
    {
        return $this->state([
            'enseignant_id' => $enseignantId,
        ]);
    }

    public function pourCours($coursId)
    {
        return $this->state([
            'cours_id' => $coursId,
        ]);
    }
}