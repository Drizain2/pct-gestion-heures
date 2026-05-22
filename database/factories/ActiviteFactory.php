<?php

namespace Database\Factories;

use App\Models\Activite;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\ParametreCalcule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActiviteFactory extends Factory
{
    protected $model = Activite::class;

    public function definition(): array
    {
        $typeAction = $this->faker->randomElement(['creation', 'mise_a_jour']);
        $complexite = $this->faker->randomElement(['niveau_1', 'niveau_2', 'niveau_3']);
        $nbSequences = $this->faker->numberBetween(1, 6);

        // Formule Vhtc = Vhn × S
        $coefficient = ParametreCalcule::getCoefficient($complexite, $typeAction);
        $heuresCalculees = round($nbSequences * $coefficient, 2);

        return [
            'enseignant_id' => Enseignant::factory(),
            'cours_id' => Cours::factory(),
            'nb_sequences' => $nbSequences,
            'complexite' => $complexite,
            'type_action' => $typeAction,
            'heures_calculees' => $heuresCalculees,
            'date_activite' => $this->faker->dateTimeBetween('-12 months', 'now')->format('Y-m-d'),
            'commentaire' => $this->faker->optional(0.6)->randomElement([
                'Création de nouvelles séquences pour le cours.',
                'Mise à jour des ressources existantes.',
                'Ajout de contenus pédagogiques supplémentaires.',
                'Adaptation du cours aux nouveaux standards.',
                'Intégration de feedbacks étudiants.',
            ]),
            'statut' => $this->faker->randomElement(['en_attente', 'validee', 'rejetee']),
            'validee_par' => User::factory(),
            'validee_le' => $this->faker->optional(0.7)->dateTimeThisYear(),
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