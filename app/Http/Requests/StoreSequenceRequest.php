<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSequenceRequest extends FormRequest
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
            "cours_id"=>"required|exists:cours,id",
            "titre"=>"required|string|max:200",
            "ordre"=>"required|integer|min:1",
            "description"=>"nullable|string"
        ];
    }

    public function messages()
    {
        return [
            "cours_id.resuired"=>"Le cours est obligatoire. ",
            "cours_id.exists"=>"Le cours selectionné est invalide",
            "titre.required"=>"Le titre de la sequence est obligatoire",
            "ordre.required"=>"L'ordre est oblligatoire"
        ];
    }
}
