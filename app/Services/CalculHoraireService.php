<?php

namespace App\Services;

use App\Models\Activite;
use App\Models\Enseignant;
use App\Models\ParametreCalcule;
use App\Models\ParametreSysteme;

class CalculHoraireService
{
    /**
     * Calcule les heures pour une activité donnée
     *
     * Formule : Heures = Nb_séquences_cours * Coefficient_niveau
     */
    public function calculerHeures(string $niveau_complexite, string $typeAction, int $nbSequences)
    {
        // 1-Recuperer le cours associé au sequenses
        // if(!$ressource->relationLoaded("sequence")){
        //     $ressource->load("sequence.cours");
        // }
        // dd("calculeservice",$ressource);
        // if(!$ressource->sequence || !$ressource->sequence->cours){
        //     return 0;
        // }

        // $cour = $ressource->sequence->cours;

        /**
         * A revoir si le nombre de sequence doit être envoyer par l'utilisateur
         */
        // 2-Recuperer le nombre de sequence
        // $nbSequences = $cour->sequences()->count();
        // dd("complexite", $ressource->complexite);
        // 3- Recuperer le coefficient de complexite
        $coefficient = ParametreCalcule::getCoefficient($niveau_complexite, $typeAction);
        // dd("coefficient",$coefficient, "nbSequences", $nbSequences);

        // 4-Calculer les heures
        $heures = round($nbSequences * $coefficient, 2);

        // 5-Retourner le resultat
        return $heures;
    }

    /**
     * Calcule le volume horaire total d'un enseignant sur une periode
     */
    // public function volumeHoraireEnseignant(int $enseignantId, ?string $debut = null, ?string $fin = null)
    // {
    //     $query = Activite::where('enseignant_id', $enseignantId)
    //         ->where('statut', 'validee');

    //     if ($debut) {
    //         $query->whereDate('date_activite', '>=', $debut);
    //     }

    //     if ($fin) {
    //         $query->whereDate('date_activite', '<=', $fin);
    //     }

    //     $activites = $query->with('ressource')->get();

    //     $totalHeures = $activites->sum('heures_calculees');
    //     $heuresCreation = $activites->where('type_action', 'creation')->sum('heures_calculees');
    //     $heuresMiseAJour = $activites->where('type_action', 'mise_a_jour')->sum('heures_calculees');

    //     // Repartition par niveau de complexite
    //     $parNiveau = $activites->groupBy('ressource.complexite')->map(fn ($groupe) => [
    //         'count' => $groupe->count(),
    //         'heures' => $groupe->sum('heures_calculees'),
    //     ]);

    //     return [
    //         'total' => $totalHeures,
    //         'creation' => $heuresCreation,
    //         'mise_a_jour' => $heuresMiseAJour,
    //         'par_niveau' => $parNiveau,
    //         'nb_activites' => $activites->count(),
    //     ];
    // }

    /**
     * Recuperer le seuil d'heure selon le grade
     */
    public function getSeuilParGrade(string $grade){
        // dd("ca passe", $grade);
        $cle = match($grade){
            "Assistant"=>"seuil_heures_assistant",
            "Maitre-Assistant"=>"seuil_heures_maitre_assistant",
            "Professeur"=>"seuil_heures_professeur",
            default=>"seuil_heure_complementaire",
        };
        return ParametreSysteme::get($cle,100);
    }
    /**
     * calculer le volume horaire complet d'un enseignant avec identification des heures complementaires
     */
    public function volumeHoraireEnseignant(int $enseignantId, ?string $debut = null, ?string $fin = null){
        $enseignant = Enseignant::findOrFail($enseignantId);
        $query = Activite::where('enseignant_id', $enseignantId)
            ->where('statut', 'validee');

        if ($debut) {
            $query->whereDate('date_activite', '>=', $debut);
        }

        if ($fin) {
            $query->whereDate('date_activite', '<=', $fin);
        }

        $activites = $query->with('cours')->get();

        $totalHeures = $activites->sum('heures_calculees');
        $heuresCreation = $activites->where('type_action', 'creation')->sum('heures_calculees');
        $heuresMiseAJour = $activites->where('type_action', 'mise_a_jour')->sum('heures_calculees');

        // Calcule des heures complementaire
        $seuil = $this->getSeuilParGrade($enseignant->grade);
        $heuresNormales = min($totalHeures, $seuil);
        $heuresComplementaires = max(0, $totalHeures - $seuil);
        $depasseSeuil = $totalHeures >$seuil;

        // Repartition par niveau de complexite
        $parNiveau = $activites->groupBy('complexite')->map(fn ($groupe) => [
            'count' => $groupe->count(),
            'heures' => $groupe->sum('heures_calculees'),
        ]);

        return [
            'total' => $totalHeures,
            'creation' => $heuresCreation,
            'mise_a_jour' => $heuresMiseAJour,
            'par_niveau' => $parNiveau,
            'nb_activites' => $activites->count(),
            'heures_normales' => $heuresNormales,
            'heures_complementaires' => $heuresComplementaires,
            'depasse_seuil' => $depasseSeuil,
            'seuil' => $seuil,
        ];
    }
}
