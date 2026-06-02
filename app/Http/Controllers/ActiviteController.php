<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActiviteRequest;
use App\Models\Activite;
use App\Models\Cours;
use App\Models\Enseignant;
use App\Models\ParametreCalcule;
use App\Services\CalculHoraireService;
use Illuminate\Http\Request;

class ActiviteController extends Controller
{
    public function __construct(private CalculHoraireService $calculHoraireService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Activite::with(['enseignant', 'cours', 'validateurUser'])->latest('date_activite');

        // Filtre par enseignant
        if ($request->filled('enseignant_id')) {
            $query->where('enseignant_id', $request->enseignant_id);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par période
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_activite', [$request->date_debut, $request->date_fin]);
        }

        // Si c'est un enseignant il ne vois que ses activités
        if (auth()->user()->hasRole('enseignant')) {
            $query->where('enseignant_id', auth()->user()->enseignant?->id);
        }

        $activites = $query->paginate(10);
        $enseignants = Enseignant::orderBy('nom')->get();

        return view('activites.index', compact('activites', 'enseignants'));
    }

    public function create()
    {
        $enseignants = Enseignant::orderBy('nom')->get();
        $enseignantSelectionne = auth()->user()->enseignant?->id;
        $isEnseignant = auth()->user()->hasRole('enseignant');
        $coefficients = ParametreCalcule::getAllCoefficients();

        if ($isEnseignant && $enseignantSelectionne) {
            $cours = Cours::with('sequences')
                ->whereHas('enseignants', fn ($q) => $q->where('enseignants.id', $enseignantSelectionne))
                ->orderBy('intitule')
                ->get();
        } else {
            $cours = Cours::with('sequences')->orderBy('intitule')->get();
        }

        return view('activites.create', compact('enseignants', 'cours', 'enseignantSelectionne', 'isEnseignant', 'coefficients'));
    }

    public function store(StoreActiviteRequest $request)
    {
        $heures = $request->input('heures_calculees');

        Activite::create([
            ...$request->validated(),
            'statut' => 'en_attente',
        ]);

        return redirect()->route('activites.index')->with('success', "Activité enregistrée - {$heures}h calculées automatiquement.");
    }

    public function show(Activite $activite)
    {
        $activite->load(['enseignant', 'cours', 'validateurUser']);

        return view('activites.show', compact('activite'));
    }

    public function destroy(Activite $activite)
    {
        if ($activite->statut == 'validee') {
            return back()->with('error', 'Impossible de supprimer une activité déjà validée');
        }
        $activite->delete();

        return redirect()->route('activites.index')->with('success', 'Activité supprimée avec succès');
    }

    // Validée une activité (admin/secretaire)
    public function valider(Activite $activite)
    {
        $activite->update([
            'statut' => 'validee',
            'validee_par' => auth()->id(),
            'validee_le' => now(),
        ]);

        return back()->with('success', 'Activité validée avec succès');
    }

    // Rejeter une activité (admin/secretaire)
    public function rejeter(Activite $activite)
    {
        $activite->update([
            'statut' => 'rejetee',
            'validee_par' => auth()->id(),
            'validee_le' => now(),
        ]);

        return back()->with('success', 'Activité rejetée avec succès');
    }

    // Recaputulatif des heures d'un enseignant
    public function recapitulatif(Request $request, Enseignant $enseignant)
    {
        $debut = $request->input('debut');
        $fin = $request->input('fin');

        $volume = $this->calculHoraireService->volumeHoraireEnseignant($enseignant->id, $debut, $fin);

        $activites = Activite::where('enseignant_id', $enseignant->id)
            ->where('statut', 'validee')
            ->with('cours')
            ->when($debut && $fin, function ($query) use ($debut, $fin) {
                $query->whereBetween('date_activite', [$debut, $fin]);
            })
            ->latest('date_activite')
            ->get();

        return view('activites.recapitulatif', compact('enseignant', 'activites', 'volume', 'debut', 'fin'));
    }
}
