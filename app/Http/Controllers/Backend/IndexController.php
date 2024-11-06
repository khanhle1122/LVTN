<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Document;
use App\Models\File;


class IndexController extends Controller
{
    public function index(){
        $projects =Project::all();
        $totalProject = $projects->count();
        return view('admin.index',compact('projects','totalProject'));
    }
}
