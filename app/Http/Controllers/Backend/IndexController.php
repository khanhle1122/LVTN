<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Document;
use App\Models\File;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{
    public function index(){
        $projects =Project::all();
        $totalProject = $projects->count();
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        return view('admin.index',compact('projects','totalProject','notifications'));
    }
}
