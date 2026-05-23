<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // ── Fetch all notifications for the authenticated user ──────
    public function index(Request $request)
    {
        // Return unread first, then read. Paginate if necessary.
        $unread = $request->user()->unreadNotifications;
        $read   = $request->user()->readNotifications()->latest()->take(20)->get();

        return response()->json([
            'unread'       => $unread,
            'read'         => $read,
            'unread_count' => $unread->count(),
        ]);
    }

    // ── Mark a single notification as read ──────────────────────
    public function read(Request $request, string $id)
    {
        // Find the notification belonging to the authenticated user
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json([
            'message'      => __('Notification marked as read.'),
            'notification' => $notification,
        ]);
    }

    // ── Mark all notifications as read ──────────────────────────
    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'message' => __('All notifications marked as read.'),
        ]);
    }
}