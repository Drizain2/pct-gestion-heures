<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    /** @use HasFactory<\Database\Factories\ActiviteFactory> */
    use HasFactory;

    protected $fillable = [
        "enseignant_id",
        "ressource_id",
        "type_action",
        "heures_calculees",
        "date_activite",
        "commentaire",
        "statut",
        "validee_par",
        "validee_le",
    ];

     protected $casts = [
        "date_activite" => "date",
        "validee_le" => "datetime",
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }

    public function validateurUser()
    {
        return $this->belongsTo(User::class, 'validee_par');
    }

    // Labels lisible
    public function getTypeActionLabelAttribute(){
        return match($this->type_action){
            'creation' => 'Création',
            'mise_a_jour' => 'Mise à jour',
            default => $this->type_action,
        };
    }

    public function getStatutBadgeAttribute(){
        return match($this->statut){
            'en_attente' => '<span class="badge bg-warning">En attente</span>',
            'validee' => '<span class="badge bg-success">Validée</span>',
            'rejetee' => '<span class="badge bg-danger">Rejetée</span>',
            default => $this->statut,
        };
    }

}
