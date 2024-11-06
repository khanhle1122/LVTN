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
        $employees = User::all(); // Phân trang với 10 bản ghi mỗi trang
        return view('admin.employee', compact('employees'));
    }

    public function addEmployee(){
        
        return view('admin.add_employee');

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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usercode' => $request->usercode,
            'role' => $request->role,
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

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'usercode' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
                'address' => 'required|string',
                'phone' => 'required|string',
                'role' => 'required|string',
            ]);

            $user->update($validatedData);

            $notification = [
                'message' => 'Nhân viên đã được chỉnh sửa thành công.',
                'alert-type' => 'success'
            ];
        } catch (ValidationException $e) {
            $errors = $e->errors();
            
            if (isset($errors['email'])) {
                $notification = [
                    'message' => 'Email đã tồn tại.',
                    'alert-type' => 'error'
                ];
            } else {
                $notification = [
                    'message' => 'Có lỗi xảy ra khi chỉnh sửa nhân viên.',
                    'alert-type' => 'error'
                ];
            }
            return redirect()->back()->with($notification)->withInput();
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Có lỗi xảy ra khi chỉnh sửa nhân viên.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification)->withInput();
        }

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



        return view('admin.division');
    }
}
