<?php

namespace App\Models;
use Illuminate\Support\Facades\Cache;

use Illuminate\Database\Eloquent\Model;

class ParametreSysteme extends Model
{
     protected $fillable = [
        'cle',
        'valeur',
        'description',
        'groupe',
    ];

    // Récuperer un parametre par sa clé
    public static function get(string $cle,mixed $default =null){
        return Cache::remember("param_{$cle}",3600, function() use($cle,$default){
            $parametre = self::where('cle',$cle)->first();
            return $parametre ? $parametre->valeur : $default;
        });
    }

    // Mettre à jour un parametre et vider le cache
    public static function set(string $cle, mixed $valeur){
        self::updateOrCreate(
            ['cle' => $cle],
            ['valeur' => $valeur]
        );
        Cache::forget("param_{$cle}");
    }
}
