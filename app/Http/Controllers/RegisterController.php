<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    // ── Show the registration form ─────────────────────────────
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // ── Handle registration ────────────────────────────────────
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'nullable|string|max:20',
            'password'              => ['required', 'confirmed', Password::min(8)],
        ]);

        // ── Create user ─────────────────────────────────────
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role'     => 'customer',   // default role
        ]);

        // ── Auto-login after registration ───────────────────
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('status', __('Account created successfully. Welcome!'));
    }
}