<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;


class NotificationController extends Controller
{
    public function clearNotification(){
        $notifications = NotificationUser::where('user_id',auth()->id())->get();

        foreach($notifications as $notification){
            $notification->is_read = 1;
            $notification->save();
        }
        return redirect()->back();


    }

    public function checkNotification($id){
        $notification = NotificationUser::find($id);
        $notification->is_read = 1;
        $notification->save();
        return redirect()->back();
    }
    public function showNotification(){
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $allNotifications = NotificationUser::where('user_id', Auth::id())
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        return view('admin.view-notification',compact('notifications','allNotifications','unreadMessagesCount'));
    }

    public function deleteNotification($id){
        $notification = NotificationUser::find($id);
        $notification->delete();
        $notification = array(
            'message' => 'Đã xoá 1 thông báo',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    
}
