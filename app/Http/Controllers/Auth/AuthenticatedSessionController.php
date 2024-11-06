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
        $request->authenticate();

        $user = Auth::user();

        // Kiểm tra trạng thái nhân viên
        if ($user->status == 1) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['Your account is locked. Please contact administrator.']);
        }

        $request->session()->regenerate();

        $url = '';
        if($request->user()->role === 'admin'){
            $url= 'admin/dashboard';
        }elseif($request->user()->role === 'supervisor'){
            $url= 'supervisor/dashboard';
        }elseif($request->user()->role === 'leader'){
            $url= 'leader/dashboard';
        }else{
            $url= 'staff/dashboard';
        }

        return redirect()->intended($url);
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
