<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'date_debut',
        'date_fin',
        'jours',
        'statut',
        'motif',
        'valide_par',
        'valide_le',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'valide_le' => 'datetime',
    ];

    // L'employé qui a fait la demande
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // La personne (RH) qui a validé ou refusé la demande
    public function validateur()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }
}
