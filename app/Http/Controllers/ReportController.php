<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Message;
use App\Models\Document;
use App\Models\Task;
use App\Models\Coat;
use App\Models\Report;
use App\Models\File;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ReportController extends Controller
{
    private function buildTaskHierarchy($tasks, $level = 0)
    {
        $result = collect();

        foreach ($tasks as $task) {
            // Thêm level để đánh dấu độ sâu của task
            $task->level = $level;
            $result->push($task);

            // Lấy các task con
            $childTasks = Task::where('parentID', $task->id)
                             ->orderBy('startDate', 'asc')
                             ->get();

            if ($childTasks->isNotEmpty()) {
                $result = $result->merge($this->buildTaskHierarchy($childTasks, $level + 1));
            }
        }

        return $result;
    }
    public function reportProject(){
        
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        $projects = Project::where('progress',100)->where('report_status',0)->get();
        $projectReported = Project::where('progress',100)->where('report_status',1)->get();
        return   view('admin.report',compact('notifications','unreadMessagesCount','projects','projectReported')); 

    }
    public function reportProjectSupervisor(){
        
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        $projects = Project::where('progress',100)->where('report_status',0)->where('userID',Auth::id())->get();
        $projectReported = Project::where('progress',100)->where('report_status',1)->where('userID',Auth::id())->get();
        return view('supervisor.report',compact('notifications','unreadMessagesCount','projects','projectReported')); 

    }
    public function reportDetail($id){
        $project = Project::find($id);
        $project->status = 1;
        $project->save();
        if($project === null){
            
            
            return view('error.404');
        }
        $documents = Document::where('projectID',$id)->get();

        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        
        $rootTasks = Task::where('parentID', 0)
                            ->where('projectID',$id)
                            ->orderBy('startDate', 'asc')
                            ->get();
        $tasks = $this->buildTaskHierarchy($rootTasks);
        $coats = Coat::where('projectID',$id)->get();
        
        $totalCost = Coat::where('projectID', $id) // Lọc theo projectID
        ->pluck('estimated_cost') // Lấy tất cả giá trị estimated_cost
        ->map(function ($cost) {
            // Loại bỏ các ký tự không phải số và chuyển thành kiểu int
            return (int) preg_replace('/[^0-9]/', '', $cost);
        })
        ->sum();
        $reports = Report::where('project_id',$project->id)->orderBy('created_at', 'desc')->get();
        return   view('admin.detail-report',compact('reports','coats','notifications','unreadMessagesCount','project','documents','tasks','totalCost')); 


    }
    public function reportDetailSupervisor($id){
        $project = Project::find($id);
        $project->status = 1;
        $project->save();
        if($project === null){
            
            
            return view('error.404');
        }
        $documents = Document::where('projectID',$id)->get();

        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        
        $rootTasks = Task::where('parentID', 0)
                            ->where('projectID',$id)
                            ->orderBy('startDate', 'asc')
                            ->get();
        $tasks = $this->buildTaskHierarchy($rootTasks);
        $coats = Coat::where('projectID',$id)->get();
        
        $totalCost = Coat::where('projectID', $id) // Lọc theo projectID
        ->pluck('estimated_cost') // Lấy tất cả giá trị estimated_cost
        ->map(function ($cost) {
            // Loại bỏ các ký tự không phải số và chuyển thành kiểu int
            return (int) preg_replace('/[^0-9]/', '', $cost);
        })
        ->sum();
        $reports = Report::where('project_id',$project->id)->orderBy('created_at', 'desc')->get();
        return   view('supervisor.detail-report',compact('reports','coats','notifications','unreadMessagesCount','project','documents','tasks','totalCost')); 


    }
    public function store(Request $request, $id)
{
    $request->validate([
        'is_pass' => 'required',
        'comment' => 'required',
        'totalCost' => 'required',
    ]);

    // Xử lý giá trị 'is_pass'
    $is_pass = $request->is_pass == "0" ? false : true;
    $userID = Auth::id(); // Sử dụng Auth::id() thay vì Auth()->id()
   
    // Tính toán tổng chi phí dựa trên projectID
    
    
    // Lưu báo cáo
    Report::create([
        'is_pass' => $is_pass,
        'totalCoat' => $request->totalCost,
        'project_id' => $id,
        'comment' => $request->comment,
        'user_id' => $userID,
    ]);

    // Cập nhật trạng thái báo cáo của project
    $project = Project::find($id);
    $project->report_status = 1;
    $project->save();

    // Thông báo cho người dùng
    $notification = array(
        'message' => 'Bạn đã viết báo cáo',
        'alert-type' => 'success'
    );

    // Chuyển hướng về trang báo cáo
    return redirect()->route('report.project')->with($notification);
}

    public function storeFlie(Request $request){
        $request->validate([
            
            'projectID' => 'required',
            'file'   => 'required'
        ]);
        $file = $request->file;

        $document=Document::where('projectID',$request->projectID)->first();
        $document_dir = 'uploads/' . $document->documentName;
        $fileName = $file->getClientOriginalName();
        
        // Lưu file và lấy đường dẫn đầy đủ
        $filePath = $file->storeAs('public/' . $document_dir, $fileName);
        File::create([
            'fileName' => $fileName,
            'filePath' => $filePath, // Lưu đường dẫn đầy đủ vào DB
            'documentID' => $document->id,
        ]);
        $notification = array(
            'message' => 'Đã thêm file báo cáo',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }

    public function editReport(Request $request){
        $request->validate([
            'is_pass' => 'required',
            'id' => 'required',
            'comment'   => 'required',
            'totalCost' => 'required'
        ]);
        $report= Report::find($request->id);
        
        $userID = Auth()->id();
        $is_pass = $request->is_pass == "0" ? false : true; 

        Report::create([
            'is_pass' => $is_pass,
            'totalCoat' => $request->totalCost,
            'project_id' => $report->project_id,
            'comment'   => $request->comment,
            'user_id'    => $userID,
        ]);
            



        $notification = array(
            'message' => 'Đã chỉnh sửa',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }
}
