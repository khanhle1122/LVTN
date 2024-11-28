<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Document;
use App\Models\File;
use App\Models\Client;
use App\Models\Report;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;


class IndexController extends Controller
{
    public function index(){
        $projects =Project::all();
        $totalProject = $projects->count();
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
        $totalClient = Client::where('role','=','contractor')->count();
        

        
        return view('admin.index', compact('totalClient', 'projects', 'totalProject', 'notifications', 'unreadMessagesCount'));
    }
}
