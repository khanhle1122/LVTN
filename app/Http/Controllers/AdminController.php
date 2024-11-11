<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Project;
use App\Models\Document;
use App\Models\File;

class AdminController extends Controller
{
    public function index(){
        $projects =Project::all();
        $project =Project::first();

        $totalProject = $projects->count();
        $inProgressProjects = $projects->where('status', 0)->count();  // Đang thực hiện
        $successProjects = $projects->where('status', 1)->count();      // Tạm dừng
        $onHoldProjects = $projects->where('status', 2)->count();  // Đang thực hiện
        $lowProjects = $projects->where('status', 3)->count();  // Đang thực hiện

        return view('admin.index',compact(
                        'projects',
                        'project',
                        'totalProject',
                        'successProjects',
                        'inProgressProjects',
                        'onHoldProjects',
                        'lowProjects'
                    
                    
                    ));
    }

    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function AdminProfile(){
        return view('admin.profile');
    }
}
