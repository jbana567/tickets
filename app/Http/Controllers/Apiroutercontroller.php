<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ApiRouterController extends Controller
{
    public function handleRequest(Request $request)
    {
        // Read JSON payload from JavaScript if it's not a multipart request
        if (!$request->isMethod('GET') && strpos($request->header('Content-Type'), 'multipart/form-data') === false) {
            $json = json_decode($request->getContent(), true);
            if (is_array($json)) {
                $request->merge($json);
            }
        }

        $action = $request->query('api');

        // ── UNIFIED LOGIN ──
        if ($action === 'login') {
            try {
                $email = $request->input('email');
                $password = $request->input('password');

                // Special case for Admin
                if ($email === 'admin@inkomane.com' && $password === 'admin123') {
                    $admin = DB::table('users')->where('email', $email)->first();
                    $adminData = [
                        'id'    => $admin ? $admin->id : 0,
                        'name'  => 'Admin User',
                        'email' => 'admin@inkomane.com',
                        'role'  => 'Admin'
                    ];
                    Session::put('auth', $adminData);
                    return response()->json(['success' => true, 'user' => $adminData]);
                }

                // Check standard users
                $user = DB::table('users')->where('email', $email)->first();
                if ($user) {
                    if (\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
                        $userData = [
                            'id'    => $user->id,
                            'name'  => $user->name,
                            'email' => $user->email,
                            'role'  => $user->role
                        ];
                        Session::put('auth', $userData);
                        return response()->json(['success' => true, 'user' => $userData]);
                    }
                }

                // Fallback for customers who only have an application but no user record yet
                $app = DB::table('applications')->where('email', $email)->first();
                if ($app && $password === 'password') { 
                    $exists = DB::table('users')->where('email', $email)->first();
                    if (!$exists) {
                        $newId = DB::table('users')->insertGetId([
                            'name' => $app->name,
                            'email' => $app->email,
                            'role' => 'Customer',
                            'password' => bcrypt('password'),
                            'metadata' => json_encode([]),
                            'created_at' => now()
                        ]);
                        $userId = $newId;
                    } else {
                        $userId = $exists->id;
                    }
                    $customerData = [
                        'id'    => $userId,
                        'name'  => $app->name,
                        'email' => $app->email,
                        'role'  => 'Customer'
                    ];
                    Session::put('auth', $customerData);
                    return response()->json(['success' => true, 'user' => $customerData]);
                }

            } catch (\Exception $e) {}
            return response()->json(['success' => false, 'message' => 'Invalid credentials.']);
        }

        // ── SUBMIT APPLICATION ──
        if ($action === 'submit_application') {
            try {
                $email = $request->input('email');
                $password = $request->input('password') ?? 'password';
                $filePath = null;
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads'), $fileName);
                    $filePath = 'uploads/' . $fileName;
                }

                $appId = DB::table('applications')->insertGetId([
                    'name' => $request->input('name'),
                    'email' => $email,
                    'department' => $request->input('department') ?? 'Sales',
                    'category' => $request->input('category') ?? 'Hardware',
                    'subject' => $request->input('subject'),
                    'description' => $request->input('description'),
                    'file_path' => $filePath,
                    'status' => 'pending',
                    'submitted_at' => now(),
                    'created_at' => now()
                ]);

                // Create user record if not exists
                $exists = DB::table('users')->where('email', $email)->exists();
                if (!$exists) {
                    DB::table('users')->insert([
                        'name' => $request->input('name'),
                        'email' => $email,
                        'role' => 'Customer',
                        'password' => bcrypt($password),
                        'metadata' => json_encode([]),
                        'created_at' => now()
                    ]);
                }

                return response()->json(['success' => true, 'id' => $appId]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'DB Error: ' . $e->getMessage()]);
            }
        }

        // ── GET DATA ──
        if ($action === 'get_data') {
            $users = []; $tickets = []; $applications = [];
            try { $users = DB::table('users')->orderBy('id', 'desc')->get()->toArray(); } catch (\Exception $e) {}
            try { $tickets = DB::table('tickets')->orderBy('id', 'desc')->get()->toArray(); } catch (\Exception $e) {}
            try { $applications = DB::table('applications')->orderBy('id', 'desc')->get()->toArray(); } catch (\Exception $e) {}
            
            // Get notifications for current user
            $notifications = [];
            $auth = Session::get('auth');
            if ($auth) {
                $notifications = DB::table('notifications')
                    ->where('user_email', $auth['email'])
                    ->where('is_read', false)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }

            return response()->json([
                'success' => true, 'auth' => $auth,
                'users' => $users, 'tickets' => $tickets, 'applications' => $applications,
                'notifications' => $notifications
            ]);
        }

        // ── CUSTOMER STATUS ──
        if ($action === 'customer_status') {
            $email = $request->input('email');
            $apps = []; $tickets = [];
            try { $apps = DB::table('applications')->where('email', $email)->get()->toArray(); } catch (\Exception $e) {}
            try { 
                $tickets = DB::table('tickets')->where('applicant_email', $email)->get()->toArray(); 
                foreach ($tickets as &$t) {
                    if (isset($t->assigned_to_email) && $t->assigned_to_email) {
                        $agent = DB::table('users')->where('email', $t->assigned_to_email)->first();
                        if ($agent) {
                            $t->agent_name = $agent->name;
                            $t->agent_contact = $agent->metadata;
                        }
                    } else if (isset($t->assigned_to) && $t->assigned_to) {
                        // Fallback for name-based assignment
                        $agent = DB::table('users')->where('name', $t->assigned_to)->first();
                        if ($agent) {
                            $t->agent_name = $agent->name;
                            $t->agent_contact = $agent->metadata;
                        }
                    }
                }
            } catch (\Exception $e) {}
            return response()->json(['success' => true, 'applications' => $apps, 'tickets' => $tickets]);
        }

        // ── UPDATE AGENT PROFILE ──
        if ($action === 'update_agent_profile') {
            try {
                $auth = Session::get('auth');
                if (!$auth || ($auth['role'] !== 'Team Agent' && $auth['role'] !== 'Admin')) {
                    return response()->json(['success' => false, 'message' => 'Unauthorized']);
                }

                $name  = $request->input('name');
                $phone = $request->input('phone');
                $email = $request->input('email');

                $id = isset($auth['id']) ? $auth['id'] : null;
                $userEmail = $auth['email'];

                if ($id) {
                    DB::table('users')->where('id', $id)->update([
                        'name' => $name,
                        'email' => $email,
                        'metadata' => json_encode(['phone' => $phone]),
                        'updated_at' => now()
                    ]);
                } else {
                    DB::table('users')->where('email', $userEmail)->update([
                        'name' => $name,
                        'email' => $email,
                        'metadata' => json_encode(['phone' => $phone]),
                        'updated_at' => now()
                    ]);
                }

                // Update session
                $auth['name'] = $name;
                $auth['email'] = $email;
                Session::put('auth', $auth);

                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }

        // ── CONFIRM SINGLE APP (Includes Auto-Assignment) ──
        if ($action === 'confirm_app') {
            $success = $this->confirmSingleApp($request->input('id'));
            return response()->json(['success' => $success]);
        }

        // ── REJECT SINGLE APP ──
        if ($action === 'reject_app') {
            try {
                // Self-repair: Ensure status column is VARCHAR and can handle 'rejected'
                // This fixes the SQLSTATE[01000] truncation error if the column is an ENUM
                try {
                    DB::statement("ALTER TABLE applications MODIFY status VARCHAR(50) DEFAULT 'pending'");
                } catch (\Exception $e) {
                    // Ignore if already VARCHAR or if user lacks permissions
                }

                $appId = $request->input('id');
                $app = DB::table('applications')->where('id', $appId)->first();
                if ($app) {
                    DB::table('applications')->where('id', $appId)->update(['status' => 'rejected']);
                    DB::table('notifications')->insert([
                        'user_email' => $app->email,
                        'message' => "Your application '{$app->subject}' has been rejected.",
                        'created_at' => now()
                    ]);
                    return response()->json(['success' => true]);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Schema Error: ' . $e->getMessage()]);
            }
            return response()->json(['success' => false, 'message' => 'Application not found']);
        }

        // ── CONFIRM ALL APPS ──
        if ($action === 'confirm_all') {
            $pendingApps = DB::table('applications')->where('status', 'pending')->get();
            $count = 0;
            foreach ($pendingApps as $app) {
                $this->confirmSingleApp($app->id);
                $count++;
            }
            return response()->json(['success' => true, 'message' => "$count applications confirmed and assigned."]);
        }

        // ── SAVE USER ──
        // Action: REGISTER (New Account)
        if ($action === 'register') {
            try {
                $email = $request->input('email');
                if (!$email) return response()->json(['success' => false, 'message' => 'Email is required']);
                
                // Check if user already exists
                $exists = DB::table('users')->where('email', $email)->exists();
                if ($exists) {
                    return response()->json(['success' => false, 'message' => 'An account with this email already exists.']);
                }

                $data = [
                    'name'         => $request->input('name') ?? explode('@', $email)[0],
                    'email'        => $email,
                    'role'         => $request->input('role') ?? 'Customer',
                    'password'     => bcrypt($request->input('password') ?? 'password'),
                    'department'   => $request->input('department') ?? 'General',
                    'payment'      => 'None',
                    'clickthrough' => 0,
                    'metadata'     => json_encode([]),
                    'created_at'   => now(),
                    'updated_at'   => now()
                ];

                DB::table('users')->insert($data);
                return response()->json(['success' => true, 'message' => 'Account created successfully! You can now log in.']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
            }
        }

        if ($action === 'save_user') {
            try {
                $auth = Session::get('auth');
                if (!$auth || $auth['role'] !== 'Admin') {
                    return response()->json(['success' => false, 'message' => 'Unauthorized: Admin access required.']);
                }

                $id = $request->input('id');
                $data = [
                    'name'         => $request->input('name'), 
                    'email'        => $request->input('email'), 
                    'role'         => $request->input('role') ?? 'Customer', 
                    'department'   => $request->input('department'), 
                    'payment'      => $request->input('payment'), 
                    'clickthrough' => $request->input('clickthrough') ?? 0,
                    'updated_at'   => now()
                ];

                if ($request->has('password') && $request->input('password')) {
                    $data['password'] = bcrypt($request->input('password'));
                }

                if ($id) {
                    DB::table('users')->where('id', $id)->update($data); 
                    return response()->json(['success' => true, 'message' => 'User updated successfully']);
                } else {
                    if (!$request->has('password')) {
                        $data['password'] = bcrypt('password'); 
                    }
                    $data['created_at'] = now();
                    $data['metadata'] = json_encode([]);
                    DB::table('users')->insert($data); 
                    return response()->json(['success' => true, 'message' => 'User created successfully']);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            }
        }

        // ── DELETE USER ──
        if ($action === 'delete_user') {
            DB::table('users')->where('id', $request->input('id'))->delete();
            return response()->json(['success' => true]);
        }

        // ── CREATE TICKET (Manual) ──
        if ($action === 'create_ticket') {
            DB::table('tickets')->insert([
                'subject' => $request->input('subject'), 
                'category' => $request->input('category') ?? 'Hardware', 
                'priority' => $request->input('priority') ?? 'Medium', 
                'status' => 'Open', 
                'applicant_email' => $request->input('email'), 
                'assigned_to' => $request->input('assignedTo'), 
                'created_at' => now()
            ]);
            return response()->json(['success' => true]);
        }

        // ── UPDATE TICKET (Lifecycle & Notifications) ──
        if ($action === 'update_ticket') {
            $id = $request->input('id');
            $status = $request->input('status');
            $ticket = DB::table('tickets')->where('id', $id)->first();
            
            if ($ticket) {
                DB::table('tickets')->where('id', $id)->update([
                    'subject' => $request->input('subject') ?? $ticket->subject, 
                    'status' => $status, 
                    'priority' => $request->input('priority') ?? $ticket->priority, 
                    'agent_response' => $request->input('agent_response') ?? $ticket->agent_response,
                    'updated_at' => now()
                ]);

                // Notify Customer of Status Change
                DB::table('notifications')->insert([
                    'user_email' => $ticket->applicant_email,
                    'message' => "Your ticket '{$ticket->subject}' status has been updated to $status.",
                    'created_at' => now()
                ]);

                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Ticket not found']);
        }

        // ── AGENT TICKETS ──
        if ($action === 'agent_tickets') {
            $agentName = Session::get('auth.name') ?? $request->input('agentName');
            return response()->json(['success' => true, 'tickets' => DB::table('tickets')->where('assigned_to', $agentName)->get()->toArray()]);
        }

        // ── MARK NOTIFICATIONS AS READ ──
        if ($action === 'clear_notifications') {
            $auth = Session::get('auth');
            if ($auth) {
                DB::table('notifications')->where('user_email', $auth['email'])->update(['is_read' => true]);
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false]);
        }

        // ── LOGOUT ──
        if ($action === 'logout') {
            Session::flush();
            return response()->json(['success' => true]);
        }

        // ── ADMIN: CHANGE ROLE ──
        if ($action === 'change_role') {
            if (Session::get('auth.role') !== 'Admin') return response()->json(['success' => false, 'message' => 'Unauthorized']);
            $userId = $request->input('userId');
            $newRole = $request->input('role');
            DB::table('users')->where('id', $userId)->update(['role' => $newRole]);
            return response()->json(['success' => true, 'message' => "Role updated to $newRole"]);
        }

        // ── ADMIN: UPDATE DB CONNECTION ──
        if ($action === 'update_db') {
            if (Session::get('auth.role') !== 'Admin') return response()->json(['success' => false, 'message' => 'Unauthorized']);
            // In a real app, this would update .env or a config table
            // For now, we simulate success
            return response()->json(['success' => true, 'message' => 'Database connection updated successfully']);
        }

        // ── FORGOT PASSWORD ──
        if ($action === 'forgot_password') {
            try {
                $email = $request->input('email');
                $user = DB::table('users')->where('email', $email)->first();
                if (!$user) {
                    return response()->json(['success' => false, 'message' => 'Email not found.']);
                }

                // Generate a simple token (in a real app, use a secure random string)
                $token = bin2hex(random_bytes(16));
                
                DB::table('password_reset_tokens')->updateOrInsert(
                    ['email' => $email],
                    ['token' => $token, 'created_at' => now()]
                );

                // In a real app, send an email. For this demo, we'll return the token.
                return response()->json(['success' => true, 'message' => 'Reset link generated!', 'token' => $token]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }

        // ── RESET PASSWORD ──
        if ($action === 'reset_password') {
            try {
                $email = $request->input('email');
                $token = $request->input('token');
                $password = $request->input('password');

                $reset = DB::table('password_reset_tokens')
                    ->where('email', $email)
                    ->where('token', $token)
                    ->first();

                if (!$reset) {
                    return response()->json(['success' => false, 'message' => 'Invalid token or email.']);
                }

                // Check if token is expired (e.g., 60 minutes)
                $createdAt = \Carbon\Carbon::parse($reset->created_at);
                if ($createdAt->addMinutes(60)->isPast()) {
                    return response()->json(['success' => false, 'message' => 'Token has expired.']);
                }

                DB::table('users')->where('email', $email)->update([
                    'password' => bcrypt($password),
                    'updated_at' => now()
                ]);

                DB::table('password_reset_tokens')->where('email', $email)->delete();

                return response()->json(['success' => true, 'message' => 'Password reset successfully!']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid action']);

    }

    private function confirmSingleApp($appId)
    {
        try {
            DB::statement("ALTER TABLE applications MODIFY status VARCHAR(50) DEFAULT 'pending'");
        } catch (\Exception $e) {}

        $app = DB::table('applications')->where('id', $appId)->first();
        if ($app) {
            DB::table('applications')->where('id', $appId)->update(['status' => 'confirmed']);
            
            $agent = DB::table('users')
                ->where('role', 'Team Agent')
                ->leftJoin('tickets', 'users.name', '=', 'tickets.assigned_to')
                ->select('users.name', DB::raw('count(tickets.id) as active_tickets'))
                ->groupBy('users.name')
                ->orderBy('active_tickets', 'asc')
                ->first();

            $agentName = $agent ? $agent->name : 'Unassigned';

            DB::table('tickets')->insert([
                'subject' => $app->subject,
                'category' => $app->category,
                'priority' => 'Medium',
                'status' => 'Open',
                'applicant_email' => $app->email,
                'assigned_to' => $agentName,
                'description' => $app->description,
                'file_path' => $app->file_path,
                'created_at' => now()
            ]);

            DB::table('notifications')->insert([
                'user_email' => $app->email,
                'message' => "Your application '{$app->subject}' has been confirmed and assigned to $agentName.",
                'created_at' => now()
            ]);
            return true;
        }
        return false;
    }
}