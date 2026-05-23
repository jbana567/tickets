<?php
// ═══════════════════════════════════════════════════════════════
// routes/web.php  —  INKOMANE
// ═══════════════════════════════════════════════════════════════

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\ProfileController;

// ── Public ──────────────────────────────────────────────────────
Route::get('/', function () {
    return view('post.index');
});


// ── Auth ────────────────────────────────────────────────────────
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);



// ── Authenticated ────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // SPA shell — all views served from the same blade template
    Route::get('/dashboard',       fn() => view('app'))->name('dashboard');
    Route::get('/submit-ticket',   fn() => view('app'))->name('submit-ticket');
    Route::get('/my-tickets',      fn() => view('app'))->name('customer.tickets');
    Route::get('/ticket-submitted',fn() => view('app'))->name('ticket.submitted');
    Route::get('/profile',         fn() => view('app'))->name('profile');
    Route::get('/docs',            fn() => view('app'))->name('docs');

    // Ticket form submit (non-SPA fallback)
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    // Profile update
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});