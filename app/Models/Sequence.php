<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    /** @use HasFactory<\Database\Factories\SequenceFactory> */
    use HasFactory;

    protected $fillable = [
        "cours_id",
        "titre",
        "ordre",
        "description",
    ];

    /**
     * Relations
     */

    public function ressources()
    {
        return $this->hasMany(Ressource::class)->orderBy("created_at", "asc");
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class,"cours_id");
    }
}
