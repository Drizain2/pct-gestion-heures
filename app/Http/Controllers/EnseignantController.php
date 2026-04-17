<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnseignantRequest;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Enseignant::query();

        // Recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nom', 'like', "%{$search}%")
                ->orWhere('prenom', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('telephone', 'like', "%{$search}%");
        }

        // filtre statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->input('statut'));
            // dd($query);
        }

        // par grade
        if ($request->filled('grade')) {
            $query->where('grade', $request->input('grade'));
        }

        $enseignants = $query->orderBy('id', 'desc')->paginate(5);

        return view('enseignants.index', compact('enseignants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('enseignants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnseignantRequest $request)
    {
        // 1- Créer un utilisateur
        $user = User::create([
            'name' => $request->nom.' '.$request->prenom,
            'email' => $request->email,
            'password' => 'uvci@2026',
        ]);

        // 2- Assigner le role
        $user->assignRole('enseignant');

        // 3- Créer l'enseignant
        Enseignant::create([
            ...$request->validated(),
            'user_id' => $user->id,
        ]);

        return redirect()
            ->route('enseignants.index')
            ->with('success', "Enseignant crée. Identifiants : {$request->email} / uvci@2026");
    }

    /**
     * Display the specified resource.
     */
    public function show(Enseignant $enseignant)
    {
        return view('enseignants.show', compact('enseignant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enseignant $enseignant)
    {
        return view('enseignants.edit', compact('enseignant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEnseignantRequest $request, Enseignant $enseignant)
    {
        $enseignant->update($request->validated());
        if($enseignant->user){
            $enseignant->user->update([
                'name'=> $request->nom.' '.$request->prenom,
                'email'=> $request->email,
            ]);
        }
        return redirect()->route('enseignants.index')->with('success', 'Enseignant modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enseignant $enseignant)
    {
        if($enseignant->user){
            $enseignant->user->delete();
        }
        $enseignant->delete();
        return redirect()->route('enseignants.index')->with('success', 'Enseignant supprimé avec succès');
    }
}
