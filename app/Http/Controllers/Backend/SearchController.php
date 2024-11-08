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

        $project = Project::first();


        // Trả về kết quả tìm kiếm
        return view('admin.search-results', compact('projects', 'users', 'files', 'query','divisions','clients','tasks','project'));
    }
}
