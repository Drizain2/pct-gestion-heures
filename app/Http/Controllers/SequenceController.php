<?php

namespace App\Http\Controllers;

use App\Models\Sequence;
use App\Http\Requests\StoreSequenceRequest;
use App\Models\Cours;

class SequenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cours $cour)
    {
       $sequences = $cour->sequences()->withCount('ressources')->get();

        return view('sequences.index', compact('cour', 'sequences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Cours $cour)
    {
        $ordre = $cour->sequences()->max('ordre') + 1;

        return view('sequences.create', compact('cour', 'ordre'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSequenceRequest $request,Cours $cour)
    {
        $cour->sequences()->create($request->validated());

        return redirect()
            ->route('cours.sequences.index', $cour)
            ->with('success', 'Séquence créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sequence $sequence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cours $cour,Sequence $sequence)
    {
        return view('sequences.edit', compact('cour', 'sequence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSequenceRequest $request,Cours $cour, Sequence $sequence)
    {
        $sequence->update($request->validated());

        return
        redirect()->route('cours.sequences.index', $cour)
            ->with('success', 'Sequence modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cours $cour,Sequence $sequence)
    {
        $sequence->delete();

        return redirect()
            ->route('cours.sequences.index', $cour)
            ->with('success', 'Sequence supprimée avec succès');
    }
}
