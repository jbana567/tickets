<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // ── Fetch tickets for the authenticated customer ────────────
    public function tickets(Request $request)
    {
        $tickets = $request->user()
            ->tickets() // Assumes User model has hasMany(Ticket::class)
            ->with('agent')
            ->latest()
            ->get();

        return response()->json([
            'tickets' => $tickets,
        ]);
    }
}