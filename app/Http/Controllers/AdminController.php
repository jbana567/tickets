<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    // ── Dashboard Statistics ────────────────────────────────────
    public function stats()
    {
        return response()->json([
            'total_users'         => User::count(),
            'total_tickets'       => Ticket::count(),
            'open_tickets'        => Ticket::where('status', 'Open')->count(),
            'resolved_tickets'    => Ticket::where('status', 'Resolved')->count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
        ]);
    }

    // ── Applications ────────────────────────────────────────────
    public function applications()
    {
        $applications = Application::where('status', 'pending')->with('user')->latest()->get();

        return response()->json(['applications' => $applications]);
    }

    public function confirmApplication($id)
    {
        $application = Application::findOrFail($id);
        $agent = $this->nextRoundRobinAgent();
        $application->update(['status' => $agent ? 'confirmed' : 'pending']);

        if ($agent) {
            Ticket::create([
                'subject' => $application->subject ?? 'Support Request',
                'description' => $application->description,
                'category' => $application->category ?? 'General',
                'priority' => $application->priority ?? 'Medium',
                'status' => 'Work',
                'applicant_email' => $application->email,
                'assigned_to' => $agent->name,
                'file_path' => $application->file_path,
            ]);
        }

        return response()->json(['message' => 'Application confirmed successfully.']);
    }

    public function confirmAllApplications()
    {
        Application::where('status', 'pending')->get()->each(function (Application $application) {
            $agent = $this->nextRoundRobinAgent();
            $application->update(['status' => $agent ? 'confirmed' : 'pending']);

            if ($agent) {
                Ticket::create([
                    'subject' => $application->subject ?? 'Support Request',
                    'description' => $application->description,
                    'category' => $application->category ?? 'General',
                    'priority' => $application->priority ?? 'Medium',
                    'status' => 'Work',
                    'applicant_email' => $application->email,
                    'assigned_to' => $agent->name,
                    'file_path' => $application->file_path,
                ]);
            }
        });

        return response()->json(['message' => 'All pending applications confirmed.']);
    }

    public function rejectApplication($id)
    {
        $application = Application::findOrFail($id);
        $application->update(['status' => 'rejected']);
        // Or $application->delete(); if you prefer hard deletion

        return response()->json(['message' => 'Application rejected.']);
    }

    // ── Tickets (Admin view) ────────────────────────────────────
    public function tickets()
    {
        $tickets = Ticket::with(['user', 'agent'])->latest()->paginate(20);

        return response()->json($tickets);
    }

    public function createTicket(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'subject'     => 'required|string|max:255',
            'description' => 'required|string',
            'priority'    => 'sometimes|in:Low,Medium,High',
        ]);

        $ticket = Ticket::create($validated);

        return response()->json([
            'message' => 'Ticket created successfully.',
            'ticket'  => $ticket,
        ], 201);
    }

    // ── User Management ─────────────────────────────────────────
    public function users()
    {
        $users = User::latest()->get();

        return response()->json(['users' => $users]);
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|in:Admin,Team Agent,Customer',
            'password' => ['required', Password::min(8)],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully.',
            'user'    => $user,
        ], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'role'     => 'sometimes|in:Admin,Team Agent,Customer',
            'password' => ['sometimes', 'nullable', Password::min(8)],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully.',
            'user'    => $user->fresh(),
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent admin from deleting themselves
        if ($user->id === request()->user()->id) {
            return response()->json(['error' => 'You cannot delete your own account.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

    // ── Reports ─────────────────────────────────────────────────
    private function nextRoundRobinAgent(): ?User
    {
        $agents = User::where('role', 'Team Agent')->orderBy('id')->get();

        if ($agents->isEmpty()) {
            return null;
        }

        $lastAssigned = Ticket::whereIn('assigned_to', $agents->pluck('name'))
            ->whereNotNull('assigned_to')
            ->latest('id')
            ->value('assigned_to');

        $lastIndex = $lastAssigned ? $agents->search(fn ($agent) => $agent->name === $lastAssigned) : false;
        $nextIndex = $lastIndex === false ? 0 : ($lastIndex + 1) % $agents->count();

        return $agents[$nextIndex];
    }

    public function reports()
    {
        // Example: Ticket counts grouped by month
        $monthlyTickets = Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Example: Ticket counts grouped by status
        $statusDistribution = Ticket::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return response()->json([
            'monthly_tickets'     => $monthlyTickets,
            'status_distribution' => $statusDistribution,
        ]);
    }
}
