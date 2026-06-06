<?php

namespace Database\Seeders;

use App\Models\AnneeAcademique;
use App\Models\ParametreSysteme;
use Illuminate\Database\Seeder;

class ParametreSystemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Paramètres généraux
        $parametres = [
            ['cle' => 'nom_universite',
                'valeur' => "Université Virtuelle du Côte D'ivoire",
                'description' => "Nom complet de  l'université",
                'groupe' => 'general',
            ],
            [
                'cle' => 'sigle_universite',
                'valeur' => 'UVCI',
                'description' => "Sigle de l'université",
                'groupe' => 'general',
            ],
            [
                'cle' => 'seuil_heure_complementaire',
                'valeur' => '192',
                'description' => "Nombre d'heures au-delà duquel les heures sont considérées comme complémentaires",
                'groupe' => 'calcul',
            ],
            [
                'cle' => 'taux_horaire_assistant',
                'valeur' => '4000',
                'description' => 'Taux horaire par défaut pour un Assistant (FCFA)',
                'groupe' => 'taux',
            ],
            [
                'cle' => 'taux_horaire_maitre_assistant',
                'valeur' => '6000',
                'description' => 'Taux horaire par défaut pour un Maitre Assistant (FCFA)',
                'groupe' => 'taux',
            ],
            [
                'cle' => 'taux_horaire_professeur',
                'valeur' => '8000',
                'description' => 'Taux horaire par défaut pour un Professeur (FCFA)',
                'groupe' => 'taux',
            ],
            [
                'cle' => 'seuil_heures_assistant',
                'valeur' => '100',
                'description' => "Seuil d'heures normales pour un assistant",
                'groupe' => 'seuils',
            ],
            [
                'cle' => 'seuil_heures_maitre_assistant',
                'valeur' => '150',
                'description' => "Seuil d'heures normales pour un maitre assistant",
                'groupe' => 'seuils',
            ],
            [
                'cle' => 'seuil_heures_professeur',
                'valeur' => '200',
                'description' => "Seuil d'heures normales pour un professeur",
                'groupe' => 'seuils',
            ],
        ];
        foreach ($parametres as $parametre) {
            ParametreSysteme::create($parametre);
        }
        //  $anneesData = [
        //     ['libelle' => '2022-2023', 'date_debut' => '2022-10-01', 'date_fin' => '2023-07-31', 'active' => false],
        //     ['libelle' => '2023-2024', 'date_debut' => '2023-10-01', 'date_fin' => '2024-07-31', 'active' => false],
        //     ['libelle' => '2024-2025', 'date_debut' => '2024-10-01', 'date_fin' => '2025-07-31', 'active' => true],
        // ];
        // foreach($anneesData as $anne){
        //     AnneeAcademique::create($anne);
        // }
    }
}
