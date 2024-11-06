<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class TaiLieuController extends Controller
{
    public function viewDocument(){

        return view('project.task');
    }


    public function deleteFolder(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        $document = Document::find($request->id);
        if(!$document){
            $notification = array(
                'message' => 'Không tìm thấy thư mục',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $files = File::where('documentID', $document->id)->get();
        foreach($files as $file){
            if(Storage::exists($file->filePath)){
                // Xoá file từ storage
                Storage::delete($file->filePath);
                $file->delete(); // Xoá file trong database
            }
        }
        Storage::deleteDirectory('public/uploads/' . $document->documentName);
        $document->delete();
        $notification = array(
            'message' => 'Dự án đã được xoá khỏi cơ sở dữ liệu',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }
    public function deleteInterFolder($id){


        $documnet = Document::find($id);

        if ($documnet) {
            // Đảo ngược trạng thái status giữa 0 và 1
            $documnet->status = $documnet->status == 1 ? 0 : 1;
            $documnet->save();
            
        }
        $notification = array(
            'message' => 'Thư mục đã xoá cục bộ',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }
    public function deleteFile(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        $file = File::find($request->id);
        if(!$file){
            $notification = array(
                'message' => 'Không tìm thấy file',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        if(Storage::exists($file->filePath)){
            // Xoá file từ storage
            Storage::delete($file->filePath);
            $file->delete(); // Xoá file trong database
        }
       
        $notification = array(
            'message' => 'Dự án đã được xoá khỏi cơ sở dữ liệu',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }
    public function deleteInterFile($id){

        
        $file = File::find($id);

        if ($file) {
            // Đảo ngược trạng thái status giữa 0 và 1
            $file->status = $file->status == 1 ? 0 : 1;
            $file->save();
            
        }
        $notification = array(
            'message' => 'File đã xoá cục bộ',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }
}
