<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class GuestController extends Controller
{
    public function index(){


        return view('guest.guest_dashboard');
    }

    public function adviseCliet(Request $request){
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required',
            'address' => 'required',
            'email' =>'required',
            'description' => 'required'
        ]);
        Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        $content = 'Một yêu cầu tư vấn từ khách hàng ';
        Notification::create([
            'title' => 'Yêu cầu tư vắn',
            'content'   => $content,
        ]);


        $notification = array(
            'message' => 'Yêu cầu của bạn đã được gửi',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

}
