<?php

namespace App\Services;

use App\Models\Activite;
use App\Models\Enseignant;
use App\Models\ParametreCalcule;
use App\Models\ParametreSysteme;

class CalculHoraireService
{
    /**
     * Formule : Vhtc = Vhn × S
     * Vhn = coefficient selon complexité et type d'action (ParametreCalcule)
     * S   = nombre de séances (séquences) travaillées
     */
    public function calculerHeures(string $niveauComplexite, string $typeAction, int $nbSequences): float
    {
        $coefficient = ParametreCalcule::getCoefficient($niveauComplexite, $typeAction);

        return round($nbSequences * $coefficient, 2);
    }

    public function getSeuilParGrade(string $grade): int|float
    {
        $cle = match ($grade) {
            'Assistant' => 'seuil_heures_assistant',
            'Maitre-Assistant' => 'seuil_heures_maitre_assistant',
            'Professeur' => 'seuil_heures_professeur',
            default => 'seuil_heure_complementaire',
        };

        return ParametreSysteme::get($cle, 100);
    }

    public function volumeHoraireEnseignant(int $enseignantId, ?string $debut = null, ?string $fin = null): array
    {
        $enseignant = Enseignant::findOrFail($enseignantId);

        $activites = Activite::where('enseignant_id', $enseignantId)
            ->where('statut', 'validee')
            ->with('cours')
            ->when($debut, fn ($q) => $q->whereDate('date_activite', '>=', $debut))
            ->when($fin, fn ($q) => $q->whereDate('date_activite', '<=', $fin))
            ->get();

        $totalHeures = $activites->sum('heures_calculees');
        $seuil = $this->getSeuilParGrade($enseignant->grade);

        return [
            'total' => $totalHeures,
            'creation' => $activites->where('type_action', 'creation')->sum('heures_calculees'),
            'mise_a_jour' => $activites->where('type_action', 'mise_a_jour')->sum('heures_calculees'),
            'par_niveau' => $activites->groupBy('complexite')->map(fn ($groupe) => [
                'count' => $groupe->count(),
                'heures' => $groupe->sum('heures_calculees'),
            ]),
            'nb_activites' => $activites->count(),
            'heures_normales' => min($totalHeures, $seuil),
            'heures_complementaires' => max(0, $totalHeures - $seuil),
            'depasse_seuil' => $totalHeures > $seuil,
            'seuil' => $seuil,
        ];
    }
}
