<?php

namespace Database\Seeders;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnseignantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        $enseignants = [
            [
                "nom" => "KONÉ",
                "prenom" => "Kouassi",
                "grade" => "Professeur",
                "statut" => "Permanent",
                "departement" => "Informatique",
                "email" => "kone.kouassi@uvci.edi.ci",
                "telephone" => "0000000000",
                "taux_horaire" => 9000
            ],
            [
                "nom" => "DIALLO",
                "prenom" => "Fatou",
                "grade" => "Professeur",
                "statut" => "Permanent",
                "departement" => "Informatique",
                "email" => "diallo.fatou@uvci.edi.ci",
                "telephone" => "0000000000",
                "taux_horaire" => 5000
            ],
            [
                "nom" => "TRAORE",
                "prenom" => "Drissa",
                "grade" => "Maitre-Assistant",
                "statut" => "Vacataire",
                "departement" => "Physique",
                "email" => "traore.drissa@uvci.edi.ci",
                "telephone" => "0000000000",
                "taux_horaire" => 8000
            ],
            [
                "nom" => "COULIBALY",
                "prenom" => "Amidou",
                "grade" => "Assistant",
                "statut" => "Vacataire",
                "departement" => "Mathematiques",
                "email" => "coulibaly.amidou@uvci.edi.ci",
                "telephone" => "0000000000",
                "taux_horaire" => 8000
            ],
        ];

        foreach ($enseignants as $data) {
            // Créer le compte user
            $user = User::create([
                "name" => $data['prenom'] . " " . $data['nom'],
                "email" => $data['email'],
                "password" => "uvci@2026"
            ]);
            $user->assignRole('enseignant');
            Enseignant::create([
                ...$data,
                "user_id" => $user->id,
                "telephone" => null
            ]);
        }
    }
}
