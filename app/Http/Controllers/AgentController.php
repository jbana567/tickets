<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    // ── Fetch tickets assigned to the authenticated agent ───────
    public function tickets(Request $request)
    {
        $tickets = $request->user()
            ->assignedTickets() // Assumes User model has hasMany(Ticket::class, 'agent_id')
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'tickets' => $tickets,
        ]);
    }

    // ── Fetch thank-you notes received by the agent ────────────
    public function thanks(Request $request)
    {
        $thanks = $request->user()
            ->receivedThanks() // Assumes User model has hasManyThrough or hasMany for thanks
            ->with('ticket', 'user')
            ->latest()
            ->get();

        return response()->json([
            'thanks' => $thanks,
        ]);
    }
}