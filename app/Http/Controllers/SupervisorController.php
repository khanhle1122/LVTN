<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationUser;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class SupervisorController extends Controller
{
    public function index(){


        return view('supervisor.supervisor_dashboade');
    }
}
