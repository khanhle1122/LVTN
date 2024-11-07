<?php

namespace App\Http\Controllers\Backend;

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

class NhanVienController extends Controller
{
    public function checkUnique(Request $request)
{
    $usercodeExists = User::where('usercode', $request->usercode)->exists();
    $emailExists = User::where('email', $request->email)->exists();

    return response()->json([
        'usercodeExists' => $usercodeExists,
        'emailExists' => $emailExists,
    ]);
}

    public function index()
    {
        $project = Project::first();
        $employees = User::all(); // Phân trang với 10 bản ghi mỗi trang
        return view('admin.employee', compact('employees','project'));
    }

    public function addEmployee(){
        $project = Project::first();
        return view('admin.add_employee',compact('project'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
            'usercode' => ['required', 'string', 'max:255'],
            'role' =>'required',
            'address'=>'required',
            'phone'=> 'required',
            'expertise'=> 'required',
        ]);

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
        
        $notification = [
            'message' => 'Nhân viên đã được thêm',
            'alert-type' => 'success'
        ];
    
        return redirect()->route('view.add.employee')->with($notification);
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
        return view('admin.division',compact('project','divisions'));
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
}
