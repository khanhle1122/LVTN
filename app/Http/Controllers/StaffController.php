<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Message;
use App\Models\Division;
use App\Models\TaskWork;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class StaffController extends Controller
{
    public function index(){
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

        $user = User::find(Auth::id());
        $divisions = TaskWork::where('division_id',$user->divisionID)->get();


        return view('staff.index',compact('divisions','notifications','unreadMessagesCount'));
    }
    public function index_profile(){
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
        $user = User::find(Auth::id());
        $userClass = User::where('divisionID', $user->divisionID)->get();

        return view('staff.profile-staff',compact('userClass','notifications','unreadMessagesCount'));
    }

    public function editProfile(Request $request)
{
    // Kiểm tra email đã tồn tại hay chưa (loại trừ người dùng hiện tại)
    $userEmailExists = User::where('email', '=', $request->email)
                            ->where('id', '!=', Auth::id()) // Không tính người dùng hiện tại
                            ->exists();

    if ($userEmailExists) {
        // Nếu email đã tồn tại, trả về thông báo lỗi
        $notification = [
            'message' => 'Email đã tồn tại.',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }

    // Validation thêm cho các trường hợp cần thiết (nếu có)
    
    // Tiến hành cập nhật thông tin người dùng
    $user = User::findOrFail(Auth::id()); // Lấy người dùng hiện tại

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'expertise' => $request->expertise,
    ]);

    // Nếu cập nhật thành công, trả về thông báo thành công
    $notification = [
        'message' => 'Cập nhật thông tin thành công!',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
}
    public function StaffLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
