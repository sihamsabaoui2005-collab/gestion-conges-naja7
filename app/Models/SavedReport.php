<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titre',
        'format',
        'modele_rapport',
        'periode_debut',
        'periode_fin',
        'departements',
        'types_conge',
        'statut',
        'regroupement',
        'indicateurs',
        'donnees',
        'resume_ia',
        'fichier_path',
        'contenu_html',
    ];

    protected $casts = [
        'periode_debut' => 'date',
        'periode_fin' => 'date',
        'departements' => 'array',
        'types_conge' => 'array',
        'indicateurs' => 'array',
        'donnees' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}