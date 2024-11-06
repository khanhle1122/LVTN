<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;


class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $notificate = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
        ]);
        $notification = array(
            'message' => 'Thông báo đã được gửi',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
        
    }

    public function showNotifications($userId)
    {
        $user = User::findOrFail($userId);
        $notifications = $user->notifications()->latest()->get();
        return view('notifications.index', compact('notifications', 'user'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);
        return redirect()->back();
    }   
}
