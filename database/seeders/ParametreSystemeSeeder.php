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
                'cle'=> 'seuil_heures_assistant',
                'valeur'=> '100',
                'description'=>"Seuil d'heures normales pour un assistant",
                'groupe'=>'seuils',
            ],
            [
                'cle'=> 'seuil_heures_maitre_assistant',
                'valeur'=> '150',
                'description'=>"Seuil d'heures normales pour un maitre assistant",
                'groupe'=>'seuils',
            ],
            [
                'cle'=> 'seuil_heures_professeur',
                'valeur'=> '200',
                'description'=>"Seuil d'heures normales pour un professeur",
                'groupe'=>'seuils',
            ]
        ];
        foreach ($parametres as $parametre) {
            ParametreSysteme::create($parametre);
        }
        // Annee academique courante
        AnneeAcademique::create([
            'libelle' => '2025-2026',
            'date_debut' => '2025-09-01',
            'date_fin' => '2026-07-30',
            'active' => true,
        ]);
    }
}
