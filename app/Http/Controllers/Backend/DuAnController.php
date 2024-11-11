<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Document;
use App\Models\File;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




class DuAnController extends Controller
{
    public function generateUniqueFileName($directory, $originalName)
    {
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $counter = 1;

        // Tên file ban đầu
        $newFileName = $fileName . '.' . $extension;

        // Kiểm tra xem file đã tồn tại chưa
        while (Storage::exists('public/' . $directory . '/' . $newFileName)) {
            // Nếu đã tồn tại, thêm số vào sau tên file
            $newFileName = $fileName . ' (' . $counter . ').' . $extension;
            $counter++;
        }

        return $newFileName;
    }
    // show all dự án 
    public function viewDA(){
        $projects= Project::all();
        $project = Project::first();
        return view('admin.project',compact('projects','project'));
    } 
    public function addProject(){
        $project = Project::first();

        return view('admin.add_project',compact('project'));

    }
    // thêm dự án 
    
   
    public function toggleStar($id = null)
    {
        $project = Project::find($id);

        if ($project) {
            // Đảo ngược trạng thái status giữa 0 và 1
            $project->toggleStar = $project->toggleStar == 1 ? 0 : 1;
            $project->save();

            
        }

        return redirect()->back();
    }




    public function store(Request $request)
    {
        $request->validate([
            'projectCode'  => 'required|string',
            'projectName'  => 'required|string',
            'clientName'   => 'required|string',
            'startDate'  => 'required|date',
            'endDate'    => 'required|date|after_or_equal:startDate',
            'userID' =>'required',
            'type' =>'required|string',
            'level' =>'required|string',
            'budget' => ' required',
            'files.*'      => 'nullable|file', 
            'description'      => 'nullable|string|max:255', 
            'address' => 'required'

        ]);
        $projectCodeExits = Project::where('projectCode',$request->projectCode)->first();

        if($projectCodeExits){

            $notification = array(
                'message' => 'Mã Dự án đã tồn tại',
                'alert-type' => 'error'
            );
        }else{
            $project = Project::create([
                'projectCode'  => $request->projectCode,
                'projectName'  => $request->projectName,
                'clientName'   => $request->clientName,
                'userID'       => $request->userID,
                'startDate'    => $request->startDate,
                'endDate'      => $request->endDate,
                'type'         => $request->type,
                'level'        => $request->level,
                'address'      => $request->address,
                'budget'       => $request->budget,
            ]);
            if ($request->filled('description')) {
                $project->description = $request->input('description');
                $project->save();
            }
            $documentName = $project->projectCode.'_'.$project->projectName;
    
            $document = Document::create([
                'documentName' => $documentName,
                'projectID' => $project->id,
                'doPath'    => 'public/uploads/'. $documentName,
            ]);
            $notification = array(
                'message' => 'Dự án đã được thêm',
                'alert-type' => 'success'
            );
            if($request->hasFile('files')) {
                
                $files = $request->file('files');
                $document_dir = 'uploads/' . $documentName;
                
                foreach ($files as $file) {
                    $originalName = $file->getClientOriginalName();
        
                    // Tạo tên file unique
                    $fileName = $this->generateUniqueFileName($document_dir, $originalName);
                    
                    // Lưu file và lấy đường dẫn đầy đủ
                    $filePath = $file->storeAs('public/' . $document_dir, $fileName);
                    File::create([
                        'fileName' => $fileName,
                        'filePath' => $filePath, // Lưu đường dẫn đầy đủ vào DB
                        'documentID' => $document->id,
                    ]);
                }
            }
        }

        
        
        // Điều hướng về trang danh sách dự án kèm thông báo
        return redirect()->route('add.project')->with($notification);
    }

    // sửa dự án 
    public function editProject(Request $request,$id){
        

        $project = Project::findOrFail($id);
        $projectCodeExits = Project::where('projectCode',$request->projectCode)
                                    ->where('id','!=',$project->id)->exists();

        if($projectCodeExits){
            $notification = array(
                'message' => 'Mã dự án đã tồn tại',
                'alert-type' => 'error'
            );


        }
       else{
        $request->validate([
            'projectCode' => 'required|string|max:255',
            'projectName' => 'required|string|max:255',
            'clientName' => 'nullable|string|max:255',
            'userID' => 'required|exists:users,id',
            'startDate' => 'required|date',
            'type'      => 'required',
            'address'   => 'required',
            'endDate' => 'required|date|after_or_equal:startDate',
            'level' => 'nullable|string|max:255',
            'budget' => 'nullable|string', // Để xử lý sau khi lấy dữ liệu
            
        ]);
         // Cập nhật dữ liệu của dự án
         $project->projectCode = $request->input('projectCode');
         $project->projectName = $request->input('projectName');
         $project->clientName = $request->input('clientName');
         $project->userID = $request->input('userID');
         $project->startDate = $request->input('startDate');
         $project->endDate = $request->input('endDate');
         $project->type = $request->input('type');
 
         $project->address = $request->input('address');
         $project->level = $request->input('level');
         if ($request->filled('budget')) {
             $project->budget = $request->input('budget');
         }
          // Lưu vào cột budget dạng decimal
         if ($request->filled('description')) {
             $project->description = $request->input('description');
         }
         
         // Lưu lại thay đổi
         $project->save();        
 
         $notification = array(
             'message' => 'dự án đã được chỉnh sửa',
             'alert-type' => 'success'
         );
       }
        
        return redirect()->route('project')->with($notification);
    }

    public function lockProject($id){
        $project = Project::find($id);
        $currentDate = now();
        
        if($project->status == 1 || $project->status == 0 || $project->status == 3){
            $project->status = 2;
            $project->save();
            $notification = array(
                'message' => 'dự án đã tạm dừng',
                'alert-type' => 'success'
            );
        }elseif($project->status == 2){
            if($project->progress == 100){
                $project->status = 1;
                $project->save();
            }elseif($project->endDate < $currentDate){
                $project->status = 3;
                $project->save();
            
            }else{
                $project->status = 0;
                $project->save();
            }
            
            $notification = array(
                'message' => 'dự án đã mở lại',
                'alert-type' => 'success'
            );
        }
        
        return redirect()->route('project')->with($notification);
    }   
}   

