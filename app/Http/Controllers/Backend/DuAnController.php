<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Document;
use App\Models\File;
use App\Models\User;
use App\Models\Client;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProjectsImport;
use App\Models\WorkingProject;
use Carbon\Carbon;



class DuAnController extends Controller{

    public function generateUniqueFileName($directory, $originalName){
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
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $contractors = Client::where('role','contractor')->get();
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        return view('admin.project',compact('projects','contractors','notifications','unreadMessagesCount'));
    } 

    // thêm dự án 
    
   
    public function toggleStar($id = null){
        $project = Project::find($id);

        if ($project) {
            // Đảo ngược trạng thái status giữa 0 và 1
            $project->toggleStar = $project->toggleStar == 1 ? 0 : 1;
            $project->save();

            
        }
        $content = Auth::user()->name . ' đã dánh dấu dự án '.$project->projectName . ' có mã dự án ' . $project->projectCode  ;
        $notificate = Notification::create([
            'title' => 'Đánh dấu dự án ',
            'content'   => $content,
        ]);
        $users = User::all();

        foreach ($users as $user) {
            NotificationUser::create([
                'user_id' => $user->id,
                'notification_id' => $notificate->id,
                'is_read' => 0, // Mặc định là chưa đọc
            ]);
        }

        return redirect()->back();
    }



    // thêm dự án
    public function store(Request $request){
        $request->validate([
            'projectCode'  => 'required|string',
            'projectName'  => 'required|string',
            'clientID'   => 'required',
            'startDate'  => 'required|date',
            'endDate'    => 'required|date|after_or_equal:startDate',
            'userID' =>'required',
            'type' =>'required|string',
            'level' =>'required|string',
            'budget' => ' required',
            'files.*'      => 'nullable|file', 
            'description'      => 'nullable|string|max:255', 
            'address' => 'required',
            'clientID'  => 'required'
        ]);
        $projectCodeExits = Project::where('projectCode',$request->projectCode)->first();

        if($projectCodeExits){

            $notification = array(
                'message' => 'Mã dự án đã tồn tại',
                'alert-type' => 'error'
            );
        }else{
            $project = Project::create([
                'projectCode'  => $request->projectCode,
                'projectName'  => $request->projectName,
                'clientID'   => $request->clientID,
                'userID'       => $request->userID,
                'startDate'    => $request->startDate,
                'endDate'      => $request->endDate,
                'type'         => $request->type,
                'level'        => $request->level,
                'address'      => $request->address,
                'budget'       => $request->budget,
                'clientID'     => $request->clientID,
                'description'  => $request->description
            ]);
            
            $client = Client::find($request->clientID);
            $client->status = 1;
            $client->save();

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
            $supervisor = User::find($project->userID);
            $content = 'Bạn được phân công là giám sát của dự án'.$project->projectName . ' có mã dự án ' . $project->projectCode  ;
            $notificate = Notification::create([
                'title' => 'Giám sát dự án',
                'content'   => $content,
            ]);
            NotificationUser::create([
                'user_id' => $supervisor->id,
                'notification_id' => $notificate->id,
                'is_read' => 0, // Mặc định là chưa đọc
            ]);

        }

        
        
        // Điều hướng về trang danh sách dự án kèm thông báo
        return redirect()->back()->with($notification);
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
            'clientID' => 'required',
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
         $project->clientID = $request->input('clientID');
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
         
         if($project->userID != $request->userID){
            $currentDate = Carbon::today();
            $outWorks = WorkingProject::where('project_id',$project->id)->where('user_id',$project->userID)->get();
            foreach($outWorks as $outWork){
                $workingProject = WorkingProject::find($outWork->id);

                if ($workingProject) {
                    $workingProject->update([
                        'out_work' => $currentDate,
                        'is_work'  => 1,
                    ]);
                }
            }


            $supervisor = User::find($request->userID);
            WorkingProject::create([
                'user_id'   => $request->userID,
                'project_id'    => $project->id,
                'at_work'   => $currentDate	
            ]);
            $content = 'Bạn được phân công là giám sát của dự án ' . $project->projectName . ' có mã dự án ' . $project->projectCode;
            $notificate = Notification::create([
                'title' => 'Giám sát dự án',
                'content'   => $content,
            ]);
            NotificationUser::create([
                'user_id' => $supervisor->id,
                'notification_id' => $notificate->id,
                'is_read' => 0, // Mặc định là chưa đọc
            ]);
        }
        $project->userID = $request->input('userID');

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
            $content = 'Đã tạm dừng dự án '.$project->projectName . ' có mã dự án ' . $project->projectCode ;
            $notificate = Notification::create([
                'title' => 'Đã tạm dừng dự án',
                'content'   => $content,
            ]);
            $users = User::all();

            foreach ($users as $user) {
                NotificationUser::create([
                    'user_id' => $user->id,
                    'notification_id' => $notificate->id,
                    'is_read' => 0, // Mặc định là chưa đọc
                ]);
            }
       

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
            $content ='Đã mở lại dự ám dự án '.$project->projectName . ' có mã dự án ' . $project->projectCode;
            $notificate = Notification::create([
                'title' => 'Đã mở lại dự án',
                'content'   => $content,
            ]);
            $users = User::all();

            foreach ($users as $user) {
                NotificationUser::create([
                    'user_id' => $user->id,
                    'notification_id' => $notificate->id,
                    'is_read' => 0, // Mặc định là chưa đọc
                ]);
            }
       
        }
        
        return redirect()->route('project')->with($notification);
    }   
    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:8192' // 8192 KB = 8MB

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
            Excel::import(new ProjectsImport, $request->file('file'));
            DB::commit();
            $notification = array(
                'message' => 'Đã Thêm thành công',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi import: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            $notification = array(
                'message' => 'Lỗi import: ' . $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    }
}   

