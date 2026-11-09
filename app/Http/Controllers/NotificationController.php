<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = Auth::user()->notifications()->findOrFail($id);
        $notif->update(['is_read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        if ($notif->link) {
            return redirect($notif->link);
        }

        return back();
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }

    public function getLatest()
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['unread' => 0, 'notifications' => []]);
        }

        $notifications = $user->notifications()->take(5)->get()->map(function ($n) {
            return [
                'id'         => $n->id,
                'title'      => $n->title,
                'message'    => $n->message,
                'type'       => $n->type,
                'link'       => $n->link,
                'is_read'    => $n->is_read,
                'time_ago'   => $n->created_at->diffForHumans(),
            ];
        });

        $unread = $user->unreadNotificationsCount();

        return response()->json([
            'unread'        => $unread,
            'notifications' => $notifications,
        ]);
    }
}

