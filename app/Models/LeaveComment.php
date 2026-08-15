<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_request_id',
        'user_id',
        'message',
        'visibilite',
    ];

    // La demande de congé concernée
    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    // L'auteur du commentaire
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}