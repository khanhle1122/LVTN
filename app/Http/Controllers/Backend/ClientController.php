<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;


class ClientController extends Controller
{
    public function index(){
        $notifications = Notification::where('is_read',0)->get();
        $clients = Client::all();
        $projects = Project::all();
        return view('admin.client.client_dashboard',compact('clients','projects','notifications'));
    }
    public function addClient(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',     
            'description' => 'required',
            'role'  => 'required'
        ]);       

        $client = Client::create([
            'name'  => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'address'  => $request->address,
            'description'=> $request->description,
            'role'  =>$request->role,
        ]);

        $notification = array(
            'message' => 'Đã thêm đối tác',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    public function editClient(Request $request){
        $request->validate([
            'id'    => 'required',
            'name'  =>'required',
            'email' =>  'required',
            'phone' =>  'required',
            'address'   => 'required',
            'description'   => 'required',
            'status'    =>'required'
        ]);  
        $client = Client::find($request->id);


        $client->name = $request->name;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->phone = $request->phone;        
        $client->description = $request->description;
        $client->status = $request->status;
        $client->save();

        $notification = array(
            'message' => 'Đã chỉnh sửa',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    public function checkRequest($id){
        $client = Client::find($id);

        $client->status = 1;
        $client->save();

        $notification = array(
            'message' => 'Đã duyệt thành công',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notification);


    }
    public function reportProject(){

        $notifications = Notification::where('is_read',0)->get();


        return   view('admin.report',compact('notifications')); 

    }
}
