<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCoursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "intitule" => "required|string|max:100",
            "filiere" => "required|string|max:100",
            "niveau" => "required|in:L1,L2,L3,M1,M2",
            "semestre" => "required|in:S1,S2,S3,S4,S5,S6,S7,S8,S9,S10",
            "nombre_heures" => "required|integer",
            "nombre_credits" => "required|integer",
            "enseignants"=>"nullable|array",
            "enseignants.*"=>"exists:enseignants,id",
            "annee_academique"=>"required|string|max:100"
        ];
    }

    public function messages()
    {
        return [
            "intitule.required" => "L'intitule est obligatoire",
            "filiere.required" => "La filiere est obligatoire",
            "niveau.required" => "Le niveau est obligatoire",
            "niveau.in" => "Le niveau sélectionné n'est pas valide",
            "semestre.required" => "Le semestre est obligatoire",
            "semestre.in" => "Le semestre selectionné n'est pas valide",
            "nombre_heures.required" => "Le nombre d'heures est obligatoire",
            "nombre_credits.required" => "Le nombre de credits est obligatoire",
            "enseignants.*.exists" => "L'enseignant n'existe pas",
            "annee_academique.required" => "L'annee academique est obligatoire"
        ];
    }
}
