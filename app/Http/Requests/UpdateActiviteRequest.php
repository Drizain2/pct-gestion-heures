<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateActiviteRequest extends FormRequest
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
            "ressource_id" => "required|exists:ressources,id",
            "type_action" => "required|in:creation,mise_a_jour",
            "date_activite" => "required|date",
            "commentaire" => "nullable|string",
        ];
    }

    public function messages(){
        return [
            "enseignant_id.required" => "L'enseignant est obligatoire",
            "enseignant_id.exists" => "L'enseignant n'existe pas",
            "ressource_id.required" => "La ressource est obligatoire",
            "ressource_id.exists" => "La ressource n'existe pas",
            "type_action.required" => "Le type d'action est obligatoire",
            "type_action.in" => "Le type d'action doit être creation ou mise_a_jour",
            "date_activite.required" => "La date d'activité est requise",
            "date_activite.date" => "La date d'activité doit être une date",
            "commentaire.string" => "Le commentaire doit être une chaîne de caractères",
        ];
    }
}
