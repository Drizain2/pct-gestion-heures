<?php

namespace App\Http\Controllers;

use App\Models\Ressource;
use App\Http\Requests\StoreRessourceRequest;
use App\Http\Requests\UpdateRessourceRequest;
use App\Models\Cours;
use App\Models\Sequence;
use App\Models\Enseignant;

class RessourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Cours $cour,Sequence $sequence)
    {
        $this->authorize("create",Ressource::class);

        $enseignants = Enseignant::orderBy("nom")->get();

        // Si un ensignant connecté on préselectionne son profile
        $enseignantSelectionne = auth()->user()->enseignant?->id;

        return view("ressources.create", compact("cour","sequence","enseignants","enseignantSelectionne"));
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(StoreRessourceRequest $request,Cours $cour,Sequence $sequence)
    {
        $this->authorize("create",Ressource::class);

        $sequence->ressources()->create($request->validated());

        return redirect()->route("cours.sequences.index",$cour)->with("success","Ressource ajoutée avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Ressource $ressource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cours $cour,Sequence $sequence,Ressource $ressource)
    {
        $this->authorize("update",$ressource);

        $enseignants = Enseignant::orderBy("nom")->get();

        return view("ressources.edit", compact("cour","sequence","ressource","enseignants"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRessourceRequest $request,Cours $cour,Sequence $sequence, Ressource $ressource,)
    {
        $this->authorize("update",$ressource);

        $ressource->update($request->validated());
        return redirect()->route("cours.sequences.index",$cour)->with("success","Ressource modifiée avec succès");
        
    }

    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Cours $cour,Sequence $sequence,Ressource $ressource)
    {
        $this->authorize("delete",$ressource);
        $ressource->delete($sequence);

        return redirect()->route("cours.sequences.index",$cour)->with("success","Ressource supprimée avec succès. ");
    }
}
