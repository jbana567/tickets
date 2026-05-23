<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // ── Show the login form ────────────────────────────────────
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ── Handle login attempt ───────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // ── Throttle: max 5 attempts per email+IP ──────────
        $throttleKey = strtolower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => __("Too many login attempts. Please try again in :seconds seconds.", [
                    'seconds' => $seconds,
                ]),
            ]);
        }

        // ── Attempt authentication ──────────────────────────
        if (! Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        )) {
            RateLimiter::hit($throttleKey, 60); // lock for 60 s

            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        // ── Success ─────────────────────────────────────────
        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        // Redirect based on role
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    // ── Handle logout ──────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}