<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ressource extends Model
{
    /** @use HasFactory<\Database\Factories\RessourceFactory> */
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "sequence_id",
        "enseignant_id",
        "titre",
        "type",
        "complexite",
        "description",
    ];

    // Labels lisibles pour les types
    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            "contenu_textuel" => "Contenu textuel",
            "video" => "Video pédagogique",
            "document" => "Document",
            "quiz" => "Quiz",
            "activite_interactive" => "Activité interactive",
            "evaluation" => "Evaluation",
            default => $this->type
        };
    }

    // Couleur badge selon le type
    public function getTypeCouleurAttribute()
    {
        return match ($this->type) {
            "contenu_textuel" => "#2E7D32",
            "video" => "#1565C0",
            "document" => "#6A1B9A",
            "quiz" => "#C62828",
            "activite_interactive" => "#FBC02D",
            "evaluation" => "#AD1457",
            default => "#555"
        };
    }

    public function getComplexiteLabelAttribute(){
        return match($this->complexite){
            "niveau_1"=>"Niveau 1 - Contenus simple + quiz + evaluation",
            "niveau_2"=>"Niveau 2 - Niveau 1 + activités interactives",
            "niveau_3"=>"Niveau 3 - Serious games, simulations",
            default=>$this->complexite
        };
    }

    /**
     * Relation 
     */

    public function sequence()
    {
        return $this->belongsTo(Sequence::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
