<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'usercode' => ['required', 'string', 'max:255'],
            'role' =>'required',
            'address' => 'required',
            'phone' => 'required',
            'position' =>'required',  

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usercode' => $request->usercode,
            'position' => $request->position,
            'role' => $request->role,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        $notification = array(
            'message' => 'Nhân viên đã được Thêm',
            'alert-type' => 'success'
        );
        
        return redirect()->route('nhansu')->with($notification);
    }
}
