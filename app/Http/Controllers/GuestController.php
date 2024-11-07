<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

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



        $notification = array(
            'message' => 'Yêu cầu của bạn đã được gửi',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

}
