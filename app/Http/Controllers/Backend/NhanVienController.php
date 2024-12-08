<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Project;
use App\Models\Division;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Message;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class NhanVienController extends Controller
{
   

    public function index()
    {
        $employees = User::all(); 
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
        return view('admin.employee', compact('employees','notifications','unreadMessagesCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
            'usercode' => ['required', 'string', 'max:255'],
            'role' =>'required',
            'address'=>'required',
            'phone'=> 'required',
            'expertise'=> 'required',
        ]);
        $userCodeExits = User::where('usercode',$request->usercode)->first();
        $userEmailExits = User::where('email',$request->email)->first();

        if($userCodeExits){

            $notification = [
                'message' => 'Mã nhân viên đã tồn tại',
                'alert-type' => 'error'
            ];            
        }
        elseif($userEmailExits){
            $notification = [
                'message' => 'email đã tồn tại',
                'alert-type' => 'error'
            ];    
        }
        else{
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'usercode' => $request->usercode,
                'role' => $request->role,
                'expertise' =>$request->expertise,
                'address'=> $request->address,
                'phone'=> $request->phone
            ]);
            if($request->role==='leader')

            $user->status_division = 1;
            $user->save();
            $notification = [
                'message' => 'Nhân viên đã được thêm',
                'alert-type' => 'success'
            ];
        }

        
    
        return redirect()->back()->with($notification);
    }
   
    public function viewDetail($id){
        $employee = User::find($id);
        return view('admin.edit_employee', compact('employee'));
 
    }

    
    
    public function editEmployee(Request $request)
    {
        $user = User::findOrFail($request->employee_id);

        // Kiểm tra usercode tồn tại
        $usercodeExists = User::where('usercode', $request->usercode)
                            ->where('id', '!=', $user->id)
                            ->exists();
        $emailExists = User::where('email', $request->email)
                            ->where('id', '!=', $user->id)
                            ->exists();

        if ($usercodeExists) {
            $notification = [
                'message' => 'Mã Nhân viên đã tồn tại.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification)->withInput();
        }
        if ($emailExists) {
            $notification = [
                'message' => 'Email Nhân viên đã tồn tại.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification)->withInput();
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'usercode' => 'required|string|max:255',
            
            'address' => 'required|string',
            'phone' => 'required|string',
            'role' => 'required|string',
            'expertise'=> 'required|string',
        ]);

        $user->name = $request->name;
        $user->usercode = $request->usercode;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->expertise	= $request->expertise	;
        $user->phone = $request->phone;
        $user->role = $request->role;

        $user->save();
        $notification = [
            'message' => 'Nhân viên đã được chỉnh sửa thành công.',
            'alert-type' => 'success'
        ];
        
        return redirect()->route('employee')->with($notification);
    }


    public function lockEmployee($id){
        $employee = User::find($id);
        if($employee->status == 0){
            $employee->status = 1;
            $notification = array(
                'message' => 'Đã khoá nhân viên:'. $employee->name . ' mã: '.$employee->usercode,
                'alert-type' => 'success'
            );
        }
        elseif($employee->status == 1){
            $employee->status = 0;
            $notification = array(
                'message' => 'Đã mở khoá nhân viên:'. $employee->name . ' mã: '.$employee->usercode,
                'alert-type' => 'success'
            );
        }
        $employee->save();

        
        
        return redirect()->route('employee')->with($notification);
    }
    public function viewDivision(){

        $project = Project::first();
        $divisions = Division::all();
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
        $supervitor = User::where('role','supervisor')->get();
        return view('admin.division',compact('project','divisions','notifications','unreadMessagesCount','supervitor'));
    }
    public function addMember(Request $request){
        $request->validate([
            'userID'=> 'required',
            'divisionID' => 'required',
        ]);
        $user = User::find($request->userID);

        $user->divisionID = $request->divisionID;

        $user->save();
        $notification = array(
            'message' => 'Đã Thêm thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }
    public function deleteMember($id){
       
        $user = User::find($id);

        $user->divisionID = null;

        $user->save();
        $notification = array(
            'message' => 'Đã Xoá thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }
    public function addDivision(Request $request){
        $request->validate([
            'divisionName'=> 'required',
            
        ]);
        Division::create([
            'divisionName' =>$request->divisionName,
        ]);
        $notification = array(
            'message' => 'Đã Thêm thành công',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }
    public function leaderPick($id){
        $user = User::find($id);
        $userLeaderOld = User::where('divisionID',$user->divisionID)->where('status_division',1)->get();
        foreach($userLeaderOld as $item){
            $item->status_division =0;
            $item->role="staff";
            $item->save();

        }
        
        $user->status_division = 1;
        $user->role = "leader";
        $user->save();
        return redirect()->back();

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
        Excel::import(new UsersImport, $request->file('file'));
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
            'message' =>  $e->getMessage(),
            'alert-type' => 'error'
        );

        return redirect()->back()->with($notification);
    }
}
}
