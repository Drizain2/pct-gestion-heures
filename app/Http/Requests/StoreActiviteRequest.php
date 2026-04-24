<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreActiviteRequest extends FormRequest
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
            "enseignant_id" => "required|exists:enseignants,id",
            "cours_id" => "required|exists:cours,id",
            "type_action" => "required|in:creation,mise_a_jour",
            "date_activite" => "required|date",
            "commentaire" => "nullable|string",
            'complexite' => 'required|in:niveau_1,niveau_2,niveau_3',
            "heures_calculees" => "required|numeric|min:0",
            "nb_sequences" => "required|numeric|min:0",
        ];
    }

    public function messages(){
        return [
            "enseignant_id.required" => "L'enseignant est obligatoire",
            "enseignant_id.exists" => "L'enseignant n'existe pas",
            "cours_id.required" => "Le cours est obligatoire",
            "cours_id.exists" => "Le cours n'existe pas",
            "type_action.required" => "Le type d'action est obligatoire",
            "type_action.in" => "Le type d'action doit être creation ou mise_a_jour",
            "date_activite.required" => "La date d'activité est requise",
            "date_activite.date" => "La date d'activité doit être une date",
            "commentaire.string" => "Le commentaire doit être une chaîne de caractères",
            "complexite.required" => "Le niveau de complexité est obligatoire",
            "complexite.in" => "Le niveau de complexité doit être niveau_1, niveau_2 ou niveau_3",
            "nb_sequences.required" => "Le nombre de séquences est obligatoire",
            "nb_sequences.numeric" => "Le nombre de séquences doit être un nombre",
            "nb_sequences.min" => "Le nombre de séquences doit être supérieur à 0",
        ];
    }
}
