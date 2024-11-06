<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Kiểm tra nếu trạng thái của user là 1 (bị khóa)
            if ($user->status == 1) {
                Auth::logout(); // Đăng xuất người dùng
                return redirect()->route('login')->withErrors(['Your account is locked. Please contact administrator.']);
            }
        }

        return $next($request);
    }
}
