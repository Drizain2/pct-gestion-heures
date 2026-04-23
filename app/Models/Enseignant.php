<?php

namespace App\Models;

use App\Services\CalculHoraireService;
use Database\Factories\EnseignantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enseignant extends Model
{
    /** @use HasFactory<EnseignantFactory> */
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

    public function activites()
    {
        return $this->hasMany(Activite::class);
    }

    // Accesseur : heures complementaire
    public function getHeuresComplementairesAttribute()
    {
        $service = app(CalculHoraireService::class);
        $volume = $service->volumeHoraireEnseignant($this->id);

        return $volume['heures_complementaires'];
    }

    // Seuil selon le grade
    public function getSeuilHeuresAttribute()
    {
        return app(CalculHoraireService::class)->getSeuilParGrade($this->grade);
    }

    // POurcentage de charge utilisé
    public function getPourcentageChargeAttribute()
    {
        $seuil = $this->seuil_heures;
        if ($seuil == 0) {
            return 0;
        }
        $total = Activite::where('enseignant_id', $this->id)
            ->where('statut', 'validee')
            ->sum('heures_calculees');

        return min(100, round(($total / $seuil) * 100, 1));
    }
}
