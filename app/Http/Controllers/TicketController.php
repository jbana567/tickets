<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index() {
        return Ticket::all();
    }

    public function store(Request $req) {
        return Ticket::create($req->all());
    }

    public function update(Request $req, $id) {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($req->all());
        return $ticket;
    }
}

