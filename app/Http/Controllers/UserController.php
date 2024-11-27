<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function import(Request $request) 
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv|max:2048'
    ]);

    try {
        DB::beginTransaction();
        Excel::import(new UsersImport, $request->file('file'));
        DB::commit();
        return redirect()->back()->with('success', 'Dữ liệu đã được import thành công.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
    }
}
}
