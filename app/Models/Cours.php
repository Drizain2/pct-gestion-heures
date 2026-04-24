<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cours extends Model
{
    /** @use HasFactory<\Database\Factories\CoursFactory> */
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'intitule',
        'filiere',
        'niveau',
        'semestre',
        'nombre_heures',
        'nombre_credits',
    ];

    /**
     * Relation
     */
    // Relation avec les enseignants
    public function enseignants()
    {
        return $this->belongsToMany(Enseignant::class, "cours_enseignant")
            ->withPivot('annee_academique')
            ->withTimestamps();
    }

    // Relation avec séquances
    public function sequences()
    {
        return $this->hasMany(Sequence::class)->orderBy("ordre", "asc");
    }

    public function getNombreSequencesAttribute(){
        return $this->sequences()->count();
    }
}
