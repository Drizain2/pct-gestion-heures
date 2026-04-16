<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnseignantRequest extends FormRequest
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
        // Si update ignore email
        $emailRule = "required|email|unique:enseignants,email";
        if($this->route('enseignant')) {
            $emailRule .= "," . $this->route('enseignant')->id;
        }
        return [
            "nom" => "required|string|max:100",
            "prenom" => "required|string|max:100",
            "grade"=>"required|in:Assistant,Maitre-Assistant,Professeur",
            "statut"=>"required|in:Permanent,Vacataire",
            "departement"=>"required|string|max:100",
            "email" => $emailRule,
            "telephone" => "nullable|string|max:100",
            "taux_horaire" => "required|numeric|min:0"
        ];
    }

    public function messages(){
        return [
            "nom.required" => "Le nom est obligatoire",
            "prenom.required" => "Le prénom est obligatoire",
            "grade.required" => "Le grade est obligatoire",
            "statut.required" => "Le statut est obligatoire",
            "departement.required" => "Le département est obligatoire",
            "email.required" => "L'email est obligatoire",
            "telephone.required" => "Le téléphone est obligatoire",
            "email.unique" => "L'email doit être unique",
        ];
    }
}
