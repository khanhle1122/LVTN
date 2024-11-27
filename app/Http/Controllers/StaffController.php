<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Message;

class StaffController extends Controller
{
    public function index(){
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                  ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
          ->where('is_read', 0)
          ->count();

        return view('staff.index',compact('notifications','unreadMessagesCount'));
    }
    public function StaffLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
