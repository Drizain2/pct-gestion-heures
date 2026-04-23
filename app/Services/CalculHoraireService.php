<?php

namespace App\Services;

use App\Models\Activite;
use App\Models\ParametreCalcule;

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
    public function volumeHoraireEnseignant(int $enseignantId, ?string $debut = null, ?string $fin = null)
    {
        $query = Activite::where('enseignant_id', $enseignantId)
            ->where('statut', 'validee');

        if ($debut) {
            $query->whereDate('date_activite', '>=', $debut);
        }

        if ($fin) {
            $query->whereDate('date_activite', '<=', $fin);
        }

        $activites = $query->with('ressource')->get();

        $totalHeures = $activites->sum('heures_calculees');
        $heuresCreation = $activites->where('type_action', 'creation')->sum('heures_calculees');
        $heuresMiseAJour = $activites->where('type_action', 'mise_a_jour')->sum('heures_calculees');

        // Repartition par niveau de complexite
        $parNiveau = $activites->groupBy('ressource.complexite')->map(fn ($groupe) => [
            'count' => $groupe->count(),
            'heures' => $groupe->sum('heures_calculees'),
        ]);

        return [
            'total' => $totalHeures,
            'creation' => $heuresCreation,
            'mise_a_jour' => $heuresMiseAJour,
            'par_niveau' => $parNiveau,
            'nb_activites' => $activites->count(),
        ];
    }
}
