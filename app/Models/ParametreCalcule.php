<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParametreCalcule extends Model
{
    protected $fillable = [
        'niveau_complexite',
        'description',
        'coefficient_creation',
        'coefficient_mise_a_jour',
    ];

     protected $casts = [
        'coefficient_creation' => 'float',
        'coefficient_mise_a_jour' => 'float',
    ];

    // Recuperer le coefficient selon le niveau de l'action
    public static function getCoefficient(string $niveauComplexite, string $typeAction)
    {
        $param = self::where('niveau_complexite', $niveauComplexite)->first();
        if (! $param) {
            return 0;
        }

        return $typeAction == 'creation' ? $param->coefficient_creation : $param->coefficient_mise_a_jour;
    }
}
