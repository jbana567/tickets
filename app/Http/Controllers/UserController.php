<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// app/Http/Controllers/UserController.php
class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // ── Explicitly hash the password ────────────────────────
        // Even though the User model has 'hashed' in $casts,
        // this is the standard secure practice in controllers.
        $validated['password'] = Hash::make($validated['password']);

        // Optional: Ensure role is set (defaults to 'customer' via DB, 
        // but good to be explicit)
        $validated['role'] = 'customer';

        $user = User::create($validated);   // saved to DB via model

        Auth::login($user); // Use the Auth facade instead of auth() helper for consistency

        return redirect('/dashboard')->with('success', 'Account created!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
}