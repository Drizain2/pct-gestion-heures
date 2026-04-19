<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AnneeAcademique;
use Illuminate\Http\Request;


class AnneeAcademiqueController extends Controller
{
    public function index()
    {
        $annees = AnneeAcademique::orderByDesc("date_debut")->get();
        return view("admin.annees.index", compact("annees"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "libelle"=>"required|unique:annee_academiques,libelle",
            "date_debut"=>"required|date",
            "date_fin"=>"required|date|after:date_debut",
        ]);
        AnneeAcademique::create($request->only("libelle", "date_debut", "date_fin"));
        return back()->with("success", "Année académique ajoutée avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function activer(AnneeAcademique $annee)
    {
        AnneeAcademique::activerAnnee($annee->id);
        return back()->with("success", "Année {{ $annee->libelle }} activée .");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnneeAcademique $annee)
    {
        if($annee->active){
            return back()->with("error", "Année {{ $annee->libelle }} ne peut pas être supprimée car elle est active .");
        }
        $annee->delete();
        return back()->with("success", "Année académique supprimée .");
    }
}
