<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRessourceRequest extends FormRequest
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
            'sequence_id' => 'required|exists:sequences,id',
            'enseignant_id' => 'required|exists:enseignants,id',
            'titre' => 'required|string|max:200',
            'type' => 'required|in:contenu_textuel,video,document,quiz,activite_interactive,evaluation',
            'complexite' => 'required|in:niveau_1,niveau_2,niveau_3',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'sequence_id.required' => 'LA séquence est obligatoire.',
            'enseignant_id.required' => "L'enseignant est obligatoire",
            'titre.required' => 'Le Titre est obligatoire',
            'type.in' => "Le type selectionné n'est pas valide",
            'type.required' => 'Le type est obligatoire',
            'complexite.require' => 'La complexité est obligatoire',
            'complexite.in' => 'La complexité selectionnée est invalide',
        ];
    }
}
