<?php
namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\InkomaneUser;
use Illuminate\Http\Request;

class InkomaneController extends Controller
{
    // Saves the "Apply for Support" form data
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:inkomane_users,email',
            'subject' => 'required'
        ]);

        // Creating the record in the migration table
        $user = InkomaneUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
            'category' => $request->category,
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'pending',
            'role' => 'Customer'
        ]);

        return response()->json($user, 201);
    }

    // Used for the Admin "Confirm" button
    public function update(Request $request, $id) {
        $user = InkomaneUser::findOrFail($id);
        $user->update($request->only(['status', 'name', 'email', 'department', 'role', 'payment']));
        return response()->json($user);
    }

    public function index() {
        return response()->json(InkomaneUser::all());
    }

    public function destroy($id) {
        InkomaneUser::destroy($id);
        return response()->json(null, 204);
    }
}