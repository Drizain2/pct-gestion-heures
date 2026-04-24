<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Http\Requests\StoreCoursRequest;
use App\Http\Requests\UpdateCoursRequest;
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

        if ($request->filled("search")) {
            $query->where(function ($q) use ($request) {
                $q->where("intitule", "like", "%{$request->search}%")
                    ->orWhere("filiere", "like", "%{$request->search}%");
            });
        }
        if ($request->filled("niveau")) {
            $query->where("niveau", $request->niveau);
        }
        if ($request->filled("semestre")) {
            $query->where("semestre", $request->semestre);
        }

        $cours = $query->orderBy("intitule")->paginate(10);
        return view("cours.index", compact("cours"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $enseignants = Enseignant::orderBy("nom", "asc")->get();
        return view("cours.create", compact("enseignants"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoursRequest $request)
    {
        $cours = Cours::create($request->safe()->except(["enseignants", "annee_academique"]));

        // Assigner les enseignants
        if ($request->filled("enseignants")) {
            $sync = [];
            foreach ($request->enseignants as $enseignantId) {
                $sync[$enseignantId] = [
                    "annee_academique" => $request->annee_academique
                ];
            }
            $cours->enseignants()->sync($sync);
        }

        return redirect()->route("cours.index")->with("success", "Cours crée avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Cours $cour)
    {
        $cour->load(['enseignants', 'sequences']);
        return view("cours.show", compact("cour"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cours $cour)
    {
        $enseignants = Enseignant::orderBy("nom", "asc")->get();
        $enseignantsIds = $cour->enseignants->pluck("id")->toArray();
        $anneeAcademique = $cour->enseignants->first()?->pivot->annee_academique ?? date("Y") . "-" . (date("Y") + 1);
        return view("cours.edit", compact("cour", "enseignants", "enseignantsIds", "anneeAcademique"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCoursRequest $request, Cours $cour)
    {
        $cour->update($request->safe()->except(["enseignants", "annee_academique"]));

        // Mettre a jour les enseignants
        if ($request->filled("enseignants")) {
            $sync = [];
            foreach ($request->enseignants as $enseignantId) {
                $sync[$enseignantId] = [
                    "annee_academique" => $request->annee_academique
                ];
            }
            $cour->enseignants()->sync($sync);
        } else {
            $cour->enseignants()->detach();
        }

        return redirect()
            ->route("cours.index")
            ->with("success", "Cours modifié avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cours $cour)
    {
        $cour->delete();
        return redirect()
            ->route("cours.index")
            ->with("success", "Cours supprimé avec succès");
    }
}
