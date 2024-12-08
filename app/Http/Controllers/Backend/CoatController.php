<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coat;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CoatsImport;

class CoatController extends Controller
{
    public function addCoat(Request $request){
        $request->validate([
            'hangmuc'   => 'required',
            'estimated_cost' => 'required',
            'description'   => 'required',
            'note'  => 'required',
            'projectID' => 'required'
        ]);

        $coat = Coat::create([
            'hangmuc'   => $request->hangmuc,
            'estimated_cost' => $request->estimated_cost,
            'description'   => $request->description,
            'note'  => $request->note,
            'projectID' => $request->projectID
        ]);
        

        $notification = array(
            'message' => 'Chi phí đã được thêm ',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);

    }
    public function editCoat(Request $request){
        $coat = Coat::find($request->id);

        $coat->hangmuc = $request->hangmuc;
        if ($request->has('estimated_cost') && !is_null($request->estimated_cost)) {

            $coat->estimated_cost = $request->estimated_cost;

        }
        $coat->description = $request->description;
        $coat->note = $request->note;

        $coat->save();
        $notification = array(
            'message' => 'Chi phí đã được chỉnh sửa ',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }
    public function deleteCoat($id){
        $coat = Coat::find($id);

        $coat->delete();
        $notification = array(
            'message' => 'Chi phí đã xoá ',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:8192', // 8192 KB = 8MB
            'projectID' => 'required|exists:projects,id',

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
            Excel::import(new CoatsImport($request->projectID), $request->file('file'));
            DB::commit();
            $notification = array(
                'message' => 'Đã Thêm thành công',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi : ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            $notification = array(
                'message' => 'Lỗi : ' . $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    }
}
