<?php

namespace App\Http\Controllers;

use App\Exports\HeuresEnseignantExport;
use App\Exports\PaiementsExport;
use App\Models\Activite;
use App\Models\Enseignant;
use App\Services\CalculHoraireService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __construct(private CalculHoraireService $calculService) {}

    public function index()
    {
        $enseignants = Enseignant::orderBy('nom')->get();

        return view('exports.index', compact('enseignants'));
    }

    /**
     * PDF Fiche individuelle enseignant
     */
    public function ficheEnseignantPdf(Request $request, Enseignant $enseignant)
    {

        $debut = $request->input('debut');
        $fin = $request->input('fin');

        $volume = $this->calculService->volumeHoraireEnseignant($enseignant->id, $debut, $fin);

        $activites = Activite::where('enseignant_id', $enseignant->id)
            ->where('statut', 'validee')
            ->with('cours')
            ->when($debut, fn ($q) => $q->whereDate('date_activite', '>=', $debut))
            ->when($fin, fn ($q) => $q->whereDate('date_activite', '<=', $fin))
            ->orderBy('date_activite', 'desc')
            ->get();

        $data = [
            'enseignant' => $enseignant,
            'volume' => $volume,
            'activites' => $activites,
            'debut' => $debut,
            'fin' => $fin,
        ];

        $pdf = Pdf::loadView('pdf.fiche_enseignant', $data)->setPaper('a4', 'portrait');

        return $pdf->download("fiche_{$enseignant->nom}_{$enseignant->prenom}.pdf");
    }

    public function heuresEnseignantExcel(Request $request, Enseignant $enseignant)
    {
        $debut = $request->input('debut');
        $fin = $request->input('fin');

        return Excel::download(new HeuresEnseignantExport($debut, $fin, $enseignant), "heures_{$enseignant->nom}_{$enseignant->prenom}.xlsx");
    }

    /**
     * PDF etat global des paiements
     */
    public function etatPaiementsPdf(Request $request)
    {
        $debut = $request->input('debut');
        $fin = $request->input('fin');

        $enseignant = Activite::where('statut', 'validee')
            ->when($debut, fn ($q) => $q->whereDate('date_activite', '>=', $debut))
            ->when($fin, fn ($q) => $q->whereDate('date_activite', '<=', $fin))
            ->select('enseignant_id', DB::raw('SUM(heures_calculees) as total_heures'))
            ->groupBy('enseignant_id')
            ->with('enseignant')
            ->having('total_heures', '>', 0)
            ->get();

        $pdf = Pdf::loadView('pdf.etat_paiements', [
            'enseignants' => $enseignant,
            'debut' => $debut,
            'fin' => $fin,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('etat_paiements_'.now()->format('Y-m-d').'.pdf');

    }

    /**
     *EXcel Etat global des heures
     */
    public function heuresGlobalExcel(Request $request)
    {
        $debut = $request->input('debut');
        $fin = $request->input('fin');

        return Excel::download(new PaiementsExport($debut, $fin), 'paiements_'.now()->format('Y-m-d').'.xlsx');
    }

    /**
     * Excel Etat des paiements
     */
    public function paiementsExcel(Request $request)
    {
        $debut = $request->input('debut');
        $fin = $request->input('fin');

        return Excel::download(new PaiementsExport($debut, $fin), 'paiements_'.now()->format('Y_m').'.xlsx');
    }
}
