<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;


class NotificationController extends Controller
{
    public function clearNotification(){
        $notifications = Notification::all();

        foreach($notifications as $notification){
            $notification->is_read = 1;
            $notification->save();
        }
        return redirect()->back();


    }

    public function checkNotification($id){
        $notification = Notification::find($id);
        $notification->is_read = 1;
        $notification->save();
        return redirect()->back();
    }
    public function showNotification(){
        $notifications = Notification::where('is_read',0)->get();
        $allNotifications = Notification::all();

        return view('admin.view-notification',compact('notifications','allNotifications'));
    }
    
}
