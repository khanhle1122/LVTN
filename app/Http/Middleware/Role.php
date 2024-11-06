<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

       $user = $request->user();

    // Nếu role của người dùng không phù hợp với vai trò yêu cầu
    if ($user->role !== $role) {
        switch ($user->role) {
            // Kiểm tra nếu người dùng là 'staff'
            case 'staff':
                return redirect('staff/dashboard');

            // Kiểm tra nếu người dùng là 'leader'
            case 'leader':
                return redirect('leader/dashboard');

            case 'supervisor':
                return redirect('supervisor/dashboard');
            
            // Kiểm tra nếu người dùng là 'admin', admin có thể truy cập tất cả
            case 'admin':
                // Admin có quyền truy cập vào tất cả
                return $next($request);

            // Default case nếu không tìm thấy role
            default:
                return redirect('/login'); // Hoặc một trang khác mà bạn muốn chuyển hướng
        }
    }
        return $next($request);
    }
}
