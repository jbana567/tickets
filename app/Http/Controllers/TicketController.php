<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // ── View a single ticket with messages ──────────────────────
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'agent', 'messages.user'])->findOrFail($id);

        // Optional: Authorization check to ensure user can view this ticket
        // $this->authorize('view', $ticket);

        return response()->json($ticket);
    }

    // ── Update a ticket (status, assign agent, etc.) ────────────
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'status'      => 'sometimes|string|in:Open,Work,In Progress,Pending Customer Response,Resolved,Closed',
            'agent_id'    => 'sometimes|nullable|exists:users,id',
            'assigned_to' => 'sometimes|nullable|string|max:255',
            'priority'    => 'sometimes|string|in:Low,Medium,High',
            'subject'     => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        $ticket->update($validated);

        return response()->json([
            'message' => 'Ticket updated successfully.',
            'ticket'  => $ticket->fresh(['user', 'agent']),
        ]);
    }

    // ── Add a message/reply to a ticket ─────────────────────────
    public function addMessage(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $message = $ticket->messages()->create([
            'user_id' => $request->user()->id,
            'body'    => $validated['body'],
        ]);

        return response()->json([
            'message'  => 'Message sent.',
            'message1' => $message->load('user'),
        ], 201);
    }

    // ── Send a thank-you note for a ticket ──────────────────────
    public function sendThankYou(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'message' => 'nullable|string|max:500',
        ]);

        // Assuming a 'thanks' relationship or a dedicated ThankYou model
        $thankYou = $ticket->thanks()->create([
            'user_id'  => $request->user()->id, // The customer thanking the agent
            'message'  => $validated['message'] ?? 'Thank you for your help!',
        ]);

        return response()->json([
            'message' => 'Thank you sent successfully.',
            'thank_you' => $thankYou,
        ], 201);
    }
}
