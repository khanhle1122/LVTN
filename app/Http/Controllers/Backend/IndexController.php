<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Document;
use App\Models\File;
use App\Models\Notification;


class IndexController extends Controller
{
    public function index(){
        $projects =Project::all();
        $totalProject = $projects->count();
        $notifications = Notification::where('is_read',0)->get();
        return view('admin.index',compact('projects','totalProject','notifications'));
    }
}
