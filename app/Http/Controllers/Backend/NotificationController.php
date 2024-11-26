<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function clearNotification(){
        $notifications = NotificationUser::all();

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

        return view('admin.view-notification',compact('notifications','allNotifications'));
    }
    
}
