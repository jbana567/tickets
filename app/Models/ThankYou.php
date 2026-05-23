<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThankYou extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'agent_id',
        'message',
    ];

    // ── Relationships ────────────────────────────────────────────

    /**
     * The ticket this thank-you belongs to
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * The customer who sent the thank-you
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The agent who received the thank-you
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}