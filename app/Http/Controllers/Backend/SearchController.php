<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project; 
use App\Models\User;
use App\Models\File;
use App\Models\Division;
use App\Models\Client;
use App\Models\Task;
use App\Models\NotificationUser;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

use App\Models\Message;



class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');  // Lấy từ khóa tìm kiếm

        // Tìm kiếm trong bảng Project
        $projects = Project::where('projectName', 'LIKE', "%{$query}%")
            ->orWhere('projectCode', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('budget', 'LIKE', "%{$query}%")
            ->get();

        // Tìm kiếm trong bảng User
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->get();

        // Tìm kiếm trong bảng Client
        $files = File::where('fileName', 'LIKE', "%{$query}%")->get();
        $divisions = Division::where('divisionName', 'LIKE', "%{$query}%")->get();
        $clients = Client::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%")
                            ->orWhere('address', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%")
                            ->get();
        $tasks = Task::where('task_name', 'LIKE', "%{$query}%")
                ->orWhere('note', 'LIKE', "%{$query}%")
                ->orWhere('task_code', 'LIKE', "%{$query}%")
                ->orWhere('budget', 'LIKE', "%{$query}%")
                ->get();

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

        // Trả về kết quả tìm kiếm
        return view('admin.search-results', compact('projects', 'users', 'files', 'query','divisions','clients','tasks','notifications','unreadMessagesCount'));
    }
}
