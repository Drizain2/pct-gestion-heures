<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeAcademique extends Model
{
    protected $fillable=[
        "libelle",
        "date_debut",
        "date_fin",
        "active"
    ];

     protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'active' => 'boolean',
    ];

    public static function activerAnnee(int $id){
        self::where('id', '!=', $id)->update(['active'=> false]);
        self::where('id', $id)->update(['active'=> true]);
    } 
}
