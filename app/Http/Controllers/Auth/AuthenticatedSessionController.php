<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Kiểm tra usercode và mật khẩu
        $credentials = [
            'usercode' => $request->usercode,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            // Lấy thông tin người dùng vừa đăng nhập
            $user = Auth::user();

            // Kiểm tra trạng thái người dùng (tài khoản bị khóa)
            if ($user->status == 1) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['Tài khoảng của bạn bị khoá xin vui lòng liên hệ quản tri viên']);
            }

            // Tạo lại session sau khi đăng nhập thành công
            $request->session()->regenerate();

            // Điều hướng người dùng đến trang dashboard dựa trên vai trò
            $url = '';
            if ($user->role === 'admin' || $user->role === 'root') {
                $url = 'admin/dashboard';
            } elseif ($user->role === 'supervisor') {
                $url = 'supervisor/index';
            } elseif ($user->role === 'leader' ) {
                $url = 'leader/index';
            } else {
                $url = 'staff/index';
            }

            return redirect()->intended($url);
        }

        // Nếu không xác thực được
        return back()->withErrors([
            'usercode' => 'Mã nhân viên hoặc mật khẩu không đúng.',
        ])->onlyInput('usercode');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
