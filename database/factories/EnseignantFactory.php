<?php

namespace Database\Factories;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnseignantFactory extends Factory
{
    protected $model = Enseignant::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Grades typiques en Côte d'Ivoire (ou adaptables)
        $grades = [
            'Assistant', 'Maitre-Assistant', 'Professeur',
        ];

        // Statuts possibles
        $statuts = ['Permanent', 'Vacataire'];

        // Départements
        $departements = [
            'Informatique', 'Mathématiques', 'Physique', 'Chimie',
            'Économie', 'Gestion', 'Droit', 'Lettres', 'Sciences Sociales',
        ];

        $email = $faker->unique()->safeEmail;

        return [
            'nom' => $faker->lastName,
            'prenom' => $faker->firstName,
            'grade' => $faker->randomElement($grades),
            'statut' => $faker->randomElement($statuts),
            'departement' => $faker->randomElement($departements),
            'email' => $email,
            'telephone' => $faker->phoneNumber, // Ex: +225 01 23 45 67 89
            'taux_horaire' => $faker->randomFloat(2, 5000, 50000), // Taux en XOF (ex: 5000 à 50000)
            'user_id' => User::factory()->state(['email' => $email]),
        ];
    }

    // State pour un enseignant actif
    public function actif()
    {
        return $this->state([
            'statut' => 'Permanent',
        ]);
    }

    // State pour un grade spécifique
    public function professeurTitulaire()
    {
        return $this->state([
            'grade' => 'Professeur',
            'taux_horaire' => $this->faker->randomFloat(2, 20000, 50000), // Taux plus élevé
        ]);
    }

    // State pour un département spécifique
    public function departementInformatique()
    {
        return $this->state([
            'departement' => 'Informatique',
        ]);
    }
}
