<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project; 
use App\Models\User;
use App\Models\File;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');  // Lấy từ khóa tìm kiếm

        // Tìm kiếm trong bảng Project
        $projects = Project::where('projectName', 'LIKE', "%{$query}%")
            ->orWhere('projectCode', 'LIKE', "%{$query}%")
            ->orWhere('clientName', 'LIKE', "%{$query}%")
            ->get();

        // Tìm kiếm trong bảng User
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->get();

        // Tìm kiếm trong bảng Client
        $files = File::where('fileName', 'LIKE', "%{$query}%")->get();
        // Trả về kết quả tìm kiếm
        return view('search-results', compact('projects', 'users', 'files', 'query'));
    }
}
