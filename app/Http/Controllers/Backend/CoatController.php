<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coat;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\NotificationUser;

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
        $coat->estimated_cost = $request->estimated_cost;
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
}
