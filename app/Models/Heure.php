<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heure extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'heure_debut',
        'heure_fin',
        'projet',
        'description',
        'total_heures'
    ];
      
    
    protected $casts = [
        'date' => 'date',
        'heure_debut' => 'datetime',
         'heure_fin' => 'datetime',
    ];

}