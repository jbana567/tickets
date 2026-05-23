<?php
// ═══════════════════════════════════════════════════════════════
// routes/api.php  —  INKOMANE JSON API
// All endpoints require session auth (web middleware applied in
// bootstrap/app.php or via RouteServiceProvider).
// ═══════════════════════════════════════════════════════════════

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TicketController;

// ── Public ──────────────────────────────────────────────────────
// Used during registration to check if an Admin already exists.
Route::get('/admin-exists', fn() =>
    response()->json(['exists' => \App\Models\User::where('role','Admin')->exists()])
);

// ── Authenticated ────────────────────────────────────────────────
Route::middleware(['auth:sanctum', 'web'])->group(function () {

    // ── Notifications ──────────────────────────────────────────
    Route::get('/notifications',             [NotificationController::class, 'index']);
    Route::post('/notifications/read-all',   [NotificationController::class, 'readAll']);
    Route::post('/notifications/{id}/read',  [NotificationController::class, 'read']);

    // ── Tickets (shared) ───────────────────────────────────────
    Route::get('/tickets/{id}',              [TicketController::class, 'show']);
    Route::put('/tickets/{id}',              [TicketController::class, 'update']);
    Route::post('/tickets/{id}/messages',    [TicketController::class, 'addMessage']);
    Route::post('/tickets/{id}/thank-you',   [TicketController::class, 'sendThankYou']);

    // ── Agents list (Admin + Agent views) ──────────────────────
    Route::get('/agents', fn() => response()->json([
        'agents' => \App\Models\User::where('role','Team Agent')->select('id','name','email')->get()
    ]));

    // ── Customer endpoints ─────────────────────────────────────
    Route::middleware('role:Customer')->group(function () {
        Route::get('/customer/tickets', [CustomerController::class, 'tickets']);
    });

    // ── Agent endpoints ────────────────────────────────────────
    Route::middleware('role:Team Agent')->group(function () {
        Route::get('/agent/tickets', [AgentController::class, 'tickets']);
        Route::get('/agent/thanks',  [AgentController::class, 'thanks']);
    });

    // ── Admin endpoints ────────────────────────────────────────
    Route::middleware('role:Admin')->group(function () {
        // Stats
        Route::get('/admin/stats', [AdminController::class, 'stats']);
        // Applications
        Route::get('/admin/applications',                  [AdminController::class, 'applications']);
        Route::post('/admin/applications/{id}/confirm',    [AdminController::class, 'confirmApplication']);
        Route::post('/admin/applications/confirm-all',     [AdminController::class, 'confirmAllApplications']);
        Route::delete('/admin/applications/{id}',          [AdminController::class, 'rejectApplication']);
        // Tickets
        Route::get('/admin/tickets',   [AdminController::class, 'tickets']);
        Route::post('/admin/tickets',  [AdminController::class, 'createTicket']);
        // Users
        Route::get('/admin/users',         [AdminController::class, 'users']);
        Route::post('/admin/users',        [AdminController::class, 'storeUser']);
        Route::put('/admin/users/{id}',    [AdminController::class, 'updateUser']);
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
        // Reports
        Route::get('/admin/reports', [AdminController::class, 'reports']);
    });
});