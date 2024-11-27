<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;


class ClientController extends Controller
{
    public function index(){
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $clients = Client::all();
        $projects = Project::all();
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        return view('admin.client.client_dashboard',compact('clients','projects','notifications','unreadMessagesCount'));
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

        return   view('admin.report',compact('notifications','unreadMessagesCount')); 

    }
    public function editRoleClient(Request $request){
        $request->validate([
            'id'    => 'required',
            'role'  =>'required',
            
        ]);
        $client = Client::find($request->id);
        $client->role = $request->role;
        $client->status = 0;
        $client->save();

        $notification = array(
            'message' => 'Đã duyệt thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    public function deleteClient($id){
        $client=Client::find($id);

        if($client->role != 'client'){
            $notification = array(
                'message' => 'Không thể xoá đối tác',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);

        }

        $client->delete();

        $notification = array(
            'message' => 'Đã xoá',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }
}
