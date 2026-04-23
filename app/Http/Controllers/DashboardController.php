<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\Ressource;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
         // Stat generales
        $stats = [
            'enseignants' => Enseignant::count(),
            'cours' => Cours::count(),
            'ressources' => Ressource::count(),
            'activites' => Activite::where('statut', 'validee')->count(),
        ];

        // Total heures validées ce mois
        $heuresMois = Activite::where('statut', 'validee')
            ->whereMonth('date_activite', now()->month)
            ->whereYear('date_activite', now()->year)
            ->sum('heures_calculees');

        // Activités en attente de validation
        $activitesEnAttente = Activite::where('statut', 'en_attente')
            ->with(['enseignant', 'ressource'])
            ->latest()
            ->take(5)
            ->get();

        // Top 5 enseignants par heures ce mois
        $topEnseignants = Activite::where('statut', 'validee')
            ->whereMonth('date_activite', now()->month)
            ->whereYear('date_activite', now()->year)
            ->select('enseignant_id', DB::raw('SUM(heures_calculees) as total_heures'))
            ->groupBy('enseignant_id')
            ->orderByDesc('total_heures')
            ->with('enseignant')
            ->take(5)
            ->get();

        // Heures par departement ce mois
        $heuresParDepartement = Activite::where('activites.statut', 'validee')
            ->whereMonth('date_activite', now()->month)
            ->whereYear('date_activite', now()->year)
            ->join('enseignants', 'activites.enseignant_id', '=', 'enseignants.id')
            ->select('enseignants.departement', DB::raw('SUM(heures_calculees) as total'))
            ->groupBy('enseignants.departement')
            ->orderByDesc('total')
            ->get();

        // Statistique par mois (6 mois )
        $statsParMois = Activite::where('statut', 'validee')
            ->where('date_activite', '>=', now()->subMonths(6))
            ->select(
                DB::raw('MONTH(date_activite) as mois'),
                DB::raw('YEAR(date_activite) as annee'),
                DB::raw('SUM(heures_calculees) as total')
            )
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'heuresMois',
            'activitesEnAttente',
            'topEnseignants',
            'heuresParDepartement',
            'statsParMois'
        ));
    }

    public function secretaire()
    {
        // Stats du secretaire
        $stats = [
            'enseignants' => Enseignant::count(),
            'cours' => Cours::count(),
            'activites_attente' => Activite::where('statut', 'en_attente')->count(),
            'activites_validees' => Activite::where('statut', 'validee')
                ->whereMonth('date_activite', now()->month)
                ->whereYear('date_activite', now()->year)
                ->count(),
        ];

        // Activités en attente
        $activitesEnAttente = Activite::where('statut', 'en_attente')
            ->with('cours', 'enseignant')
            ->latest('date_activite')
            ->take(8)
            ->get();

        // Activvités recemment validées
        $activitesValidees = Activite::where('statut', 'validee')
            ->with(['cours', 'enseignant'])
            ->latest('validee_le')
            ->take(5)
            ->get();

        return view('dashboard.secretaire', compact(
            'stats',
            'activitesEnAttente',
            'activitesValidees',
        ));
    }

    public function enseignant()
    {
        $enseignant = auth()->user()->enseignant;
        if (! $enseignant) {
            return redirect()->back()->with('error', 'vous n\'avez pas de compte enseignant');
        }

        // Stats personnelles
        $stats = [
            'heures_mois' => Activite::where('enseignant_id', $enseignant->id)
                ->where('statut', 'validee')
                ->whereMonth('date_activite', now()->month)
                ->whereYear('date_activite', now()->year)
                ->sum('heures_calculees'),
            'heures_totales' => Activite::where('enseignant_id', $enseignant->id)
                ->where('statut', 'validee')
                ->sum('heures_calculees'),
            'en_attente' => Activite::where('enseignant_id', $enseignant->id)
                ->where('statut', 'en_attente')
                ->count(),
            'ressources' => Ressource::where('enseignant_id', $enseignant->id)
                ->count(),
        ];

        // Mes dernières activités
        $derniereActivites = Activite::where('enseignant_id', $enseignant->id)
            ->with('cours')
            ->latest('date_activite')
            ->take(5)
            ->get();

        // Repartir par type de ressource
        $repartitionTypes = Activite::where('activites.enseignant_id', $enseignant->id)
            ->where('statut', 'validee')
            ->join('ressources', 'activites.cours_id', '=', 'ressources.id')
            ->select('ressources.type', DB::raw('SUM(activites.heures_calculees) as total'))
            ->groupBy('ressources.type')
            ->get();

        return view('dashboard.enseignant', compact('enseignant', 'stats', 'derniereActivites', 'repartitionTypes'));
    }
}
