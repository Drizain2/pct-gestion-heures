<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCoursRequest;
use App\Models\AnneeAcademique;
use App\Models\Cours;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Recuperer le cours avec ensignants
        $query = Cours::with('enseignants');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('intitule', 'like', "%{$request->search}%")
                    ->orWhere('filiere', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('niveau')) {
            $query->where('niveau', $request->niveau);
        }
        if ($request->filled('semestre')) {
            $query->where('semestre', $request->semestre);
        }

        $cours = $query->orderBy('intitule')->paginate(10);

        return view('cours.index', compact('cours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enseignants = Enseignant::orderBy('nom')->get();
        $annees = AnneeAcademique::orderBy('date_debut', 'desc')->get();

        return view('cours.create', compact('enseignants', 'annees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoursRequest $request)
    {
        $cours = Cours::create($request->safe()->except(['enseignants', 'annee_academique_id']));

        if ($request->filled('enseignants')) {
            $sync = [];
            foreach ($request->enseignants as $enseignantId) {
                $sync[$enseignantId] = ['annee_academique_id' => $request->annee_academique_id];
            }
            $cours->enseignants()->sync($sync);
        }

        return redirect()->route('cours.index')->with('success', 'Cours crée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cours $cour)
    {
        $cour->load(['enseignants', 'sequences']);

        return view('cours.show', compact('cour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cours $cour)
    {
        $enseignants = Enseignant::orderBy('nom')->get();
        $annees = AnneeAcademique::orderBy('date_debut', 'desc')->get();
        $enseignantsIds = $cour->enseignants->pluck('id')->toArray();
        $anneeAcademiqueId = $cour->enseignants->first()?->pivot->annee_academique_id;

        return view('cours.edit', compact('cour', 'enseignants', 'annees', 'enseignantsIds', 'anneeAcademiqueId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCoursRequest $request, Cours $cour)
    {
        $cour->update($request->safe()->except(['enseignants', 'annee_academique_id']));

        if ($request->filled('enseignants')) {
            $sync = [];
            foreach ($request->enseignants as $enseignantId) {
                $sync[$enseignantId] = ['annee_academique_id' => $request->annee_academique_id];
            }
            $cour->enseignants()->sync($sync);
        } else {
            $cour->enseignants()->detach();
        }

        return redirect()
            ->route('cours.index')
            ->with('success', 'Cours modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cours $cour)
    {
        $cour->delete();

        return redirect()
            ->route('cours.index')
            ->with('success', 'Cours supprimé avec succès');
    }

    /**
     * Recuperer les cours d'un enseignant
     */
    public function getCoursByEnseignant(Enseignant $enseignant)
    {
        $cours = Cours::with(['enseignants', 'sequences'])->whereHas('enseignants', function ($query) use ($enseignant) {
            $query->where('enseignant_id', $enseignant->id);
        })->get();

        // dd($cours->toArray());
        return response()->json($cours);
    }

    /**
     * Recuperer les cours d'un enseignant par annee academique
     */
    public function getCoursByEnseignantAndAnneeAcademique(Enseignant $enseignant, AnneeAcademique $anneeAcademique)
    {
        $cours = Cours::whereHas('enseignants', function ($query) use ($enseignant, $anneeAcademique) {
            $query->where('enseignant_id', $enseignant->id)
                ->where('annee_academique_id', $anneeAcademique->id);
        })->get();

        return response()->json($cours);
    }
}
