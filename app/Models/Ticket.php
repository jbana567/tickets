<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Ticket.php
class Ticket extends Model
{
    protected $fillable = [
        'user_id', 'subject', 'description', 'status', 'agent_response',
        'priority', 'category', 'applicant_email', 'assigned_to', 'file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'name');
    }
}
