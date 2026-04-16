<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Heure;
use Illuminate\Http\Request;

class HeureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
  {
      $heures = Heure::all();
     
      // Remplace 'nombre_heures' par le vrai nom de ta colonne
     $total = $heures->sum('total_heures');
      
     return view('heures.index', compact('heures', 'total'));
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
        'date' => 'required|date',
        'heure_debut' => 'required',
        'heure_fin' => 'required',
        'projet' => 'required|string',
        'description' => 'nullable|string',
    ]);

    $debut = Carbon::parse($request->heure_debut);
    $fin = Carbon::parse($request->heure_fin);
    $nombre_heures = $fin->diffInMinutes($debut) / 60;

    Heure::create([
        'user_id' => Auth::id(),
        'date' => $request->date,
        'heure_debut' => $request->heure_debut,
        'heure_fin' => $request->heure_fin,
        'projet' => $request->projet,
        'description' => $request->description,
        'total_heures' => $nombre_heures,
    ]);

    return redirect()->route('heures.index')->with('success', 'Heure ajoutée !');
}

  //


    /**
     * Display the specified resource.
     */
    public function show(Heure $heure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Heure $heure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Heure $heure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Heure $heure)
    {
        //
    }}

