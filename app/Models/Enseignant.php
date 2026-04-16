<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enseignant extends Model
{
    /** @use HasFactory<\Database\Factories\EnseignantFactory> */
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'grade',
        'statut',
        'departement',
        'email',
        'telephone',
        'taux_horaire',
        'user_id',
    ];

    // Nom complet
    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
