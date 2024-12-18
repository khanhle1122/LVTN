<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientsImport;
use App\Models\Contractor;
use Illuminate\Support\Facades\DB;

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
        $contactors   = Contractor::all();  
        return view('admin.client.client_dashboard',compact('contactors','clients','projects','notifications','unreadMessagesCount'));
    }
    public function addClient(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',     
            'contactorCode' => 'required',
        ]);       

        $client = Contractor::create([
            'name'  => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'address'  => $request->address,
            'contactorCode'=> $request->contactorCode,
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
            'contactorCode'   => 'required',
            'status'    =>'required'
        ]);  
        $client = Contractor::find($request->id);


        $client->name = $request->name;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->phone = $request->phone;        
        $client->contactorCode = $request->contactorCode;
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
    public function import(Request $request) 
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv|max:8192' // 8192 KB = 8MB

    ]);

    try {
        Log::info('Bắt đầu import file');
        
        if(!$request->hasFile('file')) {
            Log::error('Không tìm thấy file');
            $notification = array(
                'message' => 'Không tìm thấy file',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);        
        }

        $file = $request->file('file');
        Log::info('File được tải lên: ' . $file->getClientOriginalName());

        DB::beginTransaction();
        Excel::import(new ClientsImport, $request->file('file'));
        DB::commit();
        $notification = array(
            'message' => 'Đã Thêm thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Lỗi import: ' . $e->getMessage());
        Log::error($e->getTraceAsString());

        $notification = array(
            'message' => 'Lỗi import: ' . $e->getMessage(),
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);
    }
}
    public function request(){
        $clients = Client::all();
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

        return view('admin.client.request',compact('clients','unreadMessagesCount','notifications'));
    }
    
}
