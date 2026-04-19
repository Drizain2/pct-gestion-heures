<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParametreSysteme;
use App\Models\ParametreCalcule;
use App\Models\AnneeAcademique;

class ParametreController extends Controller
{
    public function index()
    {
        $parametres = ParametreSysteme::orderBy("groupe")->orderBy("cle")->get()->groupBy("groupe");
        $parametresCalcul = ParametreCalcule::orderBy("niveau_complexite")->get();
        $annees = AnneeAcademique::orderByDesc("date_debut")->get();

        return view("admin.parametres.index",compact("parametres","parametresCalcul","annees"));
    }

    // Metre a jour le systeme
    public function updateSysteme(Request $request){
        $request->validate([
            'parametres'=> 'required|array',
            'parametres.*'=> 'nullable|string',
        ]);

        foreach($request->parametres as $cle => $valeur){
            ParametreSysteme::set($cle, $valeur);
        }

        return back()->with('success', 'Paramètres système mis à jour avec succès');
    }

    // Mettre a jour les parametres de calcul
    public function updateCalcul(Request $request){
        $request->validate([
            "heures"=> "required|array",
        ]);

        foreach($request->heures as $id => $data){
            ParametreCalcule::where('id', $id)->update([
                'heures_creation' => $data['creation'],
                'heures_mise_a_jour' => $data['maj'],
            ]);
        }

        return back()->with('success', 'Paramètres de calcul mis à jour avec succès');
    }
}
