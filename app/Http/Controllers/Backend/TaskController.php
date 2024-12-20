<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\File;
use App\Models\Task;
use App\Models\Coat;
use App\Models\User;
use App\Models\Document;
use App\Models\TaskWork;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TasksImport;
use Carbon\Carbon;



class TaskController extends Controller
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

    public function viewtask($id) {
        $show = 0 ;
        $project = Project::find($id);
        if($project === null){
            
            
            return view('error.404');
        }
        $documents = Document::where('projectID',$id)->get();
        
        $rootTasks = Task::where('parentID', 0)
                            ->where('projectID',$id)
                            ->orderBy('startDate', 'asc')
                            ->get();

        // Xây dựng cây task phân cấp
        $tasks = $this->buildTaskHierarchy($rootTasks);
        $coats = Coat::where('projectID',$project->id)->get();
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();

        // Kiểm tra nếu project không tồn tại
        if (!$project) {
            $notification = array(
                'message' => 'dự án không tồn tại',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        // Trả về view với project và tasks
        return view('admin.task', compact('project','documents','tasks','coats','notifications','unreadMessagesCount'));
    }
    public function viewtaskSupervisor($id) {
        $show = 0 ;
        $project = Project::find($id);
        if($project === null){
            
            
            return view('error.404');
        }
        $documents = Document::where('projectID',$id)->get();
        
        $rootTasks = Task::where('parentID', 0)
                            ->where('projectID',$id)
                            ->orderBy('startDate', 'asc')
                            ->get();

        // Xây dựng cây task phân cấp
        $tasks = $this->buildTaskHierarchy($rootTasks);
        $coats = Coat::where('projectID',$project->id)->get();
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();

        // Kiểm tra nếu project không tồn tại
        if (!$project) {
            $notification = array(
                'message' => 'dự án không tồn tại',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        // Trả về view với project và tasks
        return view('supervisor.task', compact('project','documents','tasks','coats','notifications','unreadMessagesCount'));
    }
    public function viewtaskLeader($id) {
        $show = 0 ;
        $project = Project::find($id);
        if($project === null){
            
            
            return view('error.404');
        }
        $documents = Document::where('projectID',$id)->get();
        
        $rootTasks = Task::where('parentID', 0)
                            ->where('projectID',$id)
                            ->orderBy('startDate', 'asc')
                            ->get();
                            $user = User::find(Auth::id());

        // Xây dựng cây task phân cấp
        $tasks = Task::where('userID',$user->id)->where('projectID',$id)->get();
        $coats = Coat::where('projectID',$project->id)->get();
        $notifications = NotificationUser::where('user_id', Auth::id())
        ->where('is_read', 0)
        ->with('notification') // Kèm thông tin từ bảng `notifications`
        ->get();
        $divisions = TaskWork::where('division_id',$user->divisionID)->get();

        // Kiểm tra nếu project không tồn tại
        if (!$project) {
            $notification = array(
                'message' => 'dự án không tồn tại',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $unreadMessagesCount = Message::whereHas('chatRoom', function ($query) {
            $query->where('user_id', Auth::id())
                    ->orWhere('other_user_id', Auth::id());
        })->where('sender_id', '!=', Auth::id())
            ->where('is_read', 0)
            ->count();
        // Trả về view với project và tasks
        return view('leader.task_leader', compact('divisions','project','documents','tasks','coats','notifications','unreadMessagesCount'));
    }
    
    

    public function addDo(Request $request){
        $request->validate([
            'documentName' => 'required',
            'parentID' => 'required',
            

        ]);
        $document=Document::create([
            'parentID'=> $request->parentID,
            'documentName' => $request->documentName,
            'projectID' => $request->projectID,
            'doPath'    => 'public/uploads/'. $request->documentName,
        ]);
        $documents = Document::find($request->parentID);
        if($request->file('files')){
            $files = $request->file('files');
            $document_dir = 'uploads/' . $documents->documentName .'/'. $document->do_son_name;
            
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
        
    
        $notification = array(
            'message' => 'Thư mục và file đã được thêm ',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);


    }
    
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

    public function addFile(Request $request){
        
        $request->validate([
            'documentID' =>'required',
            'files.*' => 'required|file',
        ]);
        $files = $request->file('files');
        $document=Document::find($request->documentID);
        $document_dir = 'uploads/' . $document->documentName;
        
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();

            // Tạo tên file unique
            $fileName = $this->generateUniqueFileName($document_dir, $originalName);
            
            // Lưu file và lấy đường dẫn đầy đủ
            $filePath = $file->storeAs('public/' . $document_dir, $fileName);
            File::create([
                'fileName' => $fileName,
                'filePath' => $filePath, // Lưu đường dẫn đầy đủ vào DB
                'documentID' => $request->documentID,
            ]);
        }
        $notification = array(
            'message' => 'Tài liệu đã được thêm',
            'alert-type' => 'success'
        );
        $show = 0;
        return redirect()->back()->with($notification,$show);
        
    }
    public function addTask(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string',
            'task_code' => 'required',
            'note' => 'required|string', 
            'endDate' => 'required|date',
            'startDate' => 'required|date',
            'projectID' => 'required',
            'userID' => 'required',
            'parentID' => 'required',
        ]);
        //kiểm tra mã dự án
        $project = Project::find($request->projectID);
        $taskCodeExits = Task::where('task_code',$request->task_code)->exists();
        if($taskCodeExits){
            $notification = array(
                'message' => 'Mã công việc đã tồn tại',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        // kiểm tra startDate và endDate
        $startDate = \Carbon\Carbon::parse($request->startDate);
        $endDate = \Carbon\Carbon::parse($request->endDate);
        $duration = $endDate->diffInDays($startDate);

       
        $parentTasks = Task::where('id',$request->parentID)->get();

        if( $request->startDate < $project->startDate ){
            $notification = array(
                'message' => 'Ngày bắt đầu công việc không được trước ngày bắt đầu của dự án',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        if( $request->parentID != 0)
        foreach($parentTasks as $parentTask){
            if($request->startDate < $parentTask->startDate){
                $notification = array(
                    'message' => 'Ngày bắt đầu công việc không được trước ngày bắt đầu của công việc tiên quyết',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }

        }

        $updatePartent = Task::where('parentID',$request->parentID)
                               ->where('projectID', $request->projectID)->get();
        // Trước khi tạo task mới, kiểm tra và điều chỉnh thời gian nếu cần
        $existingParentTask = Task::where('projectID', $request->projectID)
                                        ->where('parentID', 0)
                                        ->get();

        // Tạo task mới với thời gian đã được điều chỉnh
        $task = Task::create([
            'task_name' => $request->task_name,
            'task_code' => $request->task_code,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'note' => $request->note,
            'parentID' => $request->parentID,
            'projectID' => $request->projectID,
            'userID' => $request->userID,
            'duration' => $duration,
        ]);
        if ($request->parentID == 0) {
            
            foreach ($existingParentTask as $item ) {

                $item->parentID = $task->id;
                $item->save();
            }

        }
        $supervisor = User::find($task->userID);
        $project = Project::find($request->projectID);
        if ($supervisor ) {
            // Tạo thông báo
            $content = 'Bạn được phân công phụ trách công việc ' . $task->task_name . ' có mã công việc ' . $task->task_code . ' của dự án '. $project->projectName .' mã ' . $project->projectCode;
            $notificate = Notification::create([
                'title' => 'Việc làm của bạn',
                'content'   => $content,
            ]);
            if($supervisor->divisionID == null){

            
            NotificationUser::create([
                'user_id' => $supervisor->id,
                'notification_id' => $notificate->id,
                'is_read' => 0, // Mặc định là chưa đọc
            ]);
            }
            else{
                $currentDate = Carbon::today();
                $users = User::where('divisionID',$supervisor->divisionID)->get();

                
                foreach($users as $user){
                    NotificationUser::create([
                        'user_id' => $user->id,
                        'notification_id' => $notificate->id,
                        'is_read' => 0, // Mặc định là chưa đọc
                    ]);
                }
                TaskWork::create([
                    'task_id'   => $task->id,
                    'division_id'    => $supervisor->divisionID,
                    'at_work'   => $currentDate	
                ]); 
            }


        }

        $allTasks = Task::where('projectID', $project->id)->get();
        $totalWeightedProgress = 0;
        $totalWeight = 0;

        foreach ($allTasks as $projectTask) {
            $taskWeight = max(1, \Carbon\Carbon::parse($projectTask->endDate)
                ->diffInDays(\Carbon\Carbon::parse($projectTask->startDate)));
            
            $totalWeightedProgress += ($projectTask->progress * $taskWeight);
            $totalWeight += $taskWeight;
        }

        if ($totalWeight > 0) {
            $project->progress = round($totalWeightedProgress / $totalWeight);
        }

        $currentDate = \Carbon\Carbon::now();
        if ($project->endDate < $currentDate ) {
            $project->status = 3; // Quá hạn
        } elseif ($project->progress == 100) {
            $project->status = 1; // Đã hoàn thành
        }

        $project->save();

        $notification = array(
            'message' => 'Công việc đã được thêm ',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
   
    public function updateProgressTask(Request $request) {
        $task = Task::find($request->taskID);
        
        if ($task) {
            $task->progress = $request->progress;
            
            // Lấy ngày hiện tại
            $currentDate = now();
            
            // Kiểm tra thời gian cho task
            if ($task->endDate < $currentDate) {
                // Nếu đã quá thời hạn
                $task->status = 2; // Quá hạn
            } elseif($task->progress == 100 ) {
                // Nếu chưa quá thời hạn và hoàn thành
                $task->status = 1; // Hoàn thành
            }
            
            $task->save();
    
            // Cập nhật progress của project
        $project = Project::find($task->projectID);

        $allTasks = Task::where('projectID', $project->id)->get();
        $totalWeightedProgress = 0;
        $totalWeight = 0;

        foreach ($allTasks as $projectTask) {
            $taskWeight = max(1, \Carbon\Carbon::parse($projectTask->endDate)
                ->diffInDays(\Carbon\Carbon::parse($projectTask->startDate)));
            
            $totalWeightedProgress += ($projectTask->progress * $taskWeight);
            $totalWeight += $taskWeight;
        }

        if ($totalWeight > 0) {
            $project->progress = round($totalWeightedProgress / $totalWeight);
        }

        $currentDate = \Carbon\Carbon::now();
        if ($project->endDate < $currentDate && $project->progress < 100) {
            $project->status = 3; // Quá hạn
        } elseif ($project->progress == 100) {
            $project->status = 1; // Đã hoàn thành
        }

        $project->save();
    
        $notification = [
            'message' => 'Tiến độ đã được cập nhật',
            'alert-type' => 'success'
        ];
        $content =Auth::user()->name . ' đã cập nhật tiến độ dự án '. $project->projectName .' có mã: '.$project->projectCode;
        Notification::create([
            'title' => 'Cập nhật tiến độ dự án',
            'content'   => $content,

        ]);


        return redirect()->back()->with($notification);
        }
    }

    // chỉnh sửa task

    public function editTask(Request $request)
{
    $request->validate([
        'task_name' => 'required|string',
        'task_code' => 'required|string',
        'endDate' => 'required|date',
        'startDate' => 'required|date',
        'projectID' => 'required',
        'userID' => 'required',
        'status' => 'required',
        'task_id' => 'required',
        'progress' => 'required|numeric|min:0|max:100',
    ]);

    try {
        DB::beginTransaction();
        
        // Lấy project trước khi validation
        $project = Project::findOrFail($request->projectID);

        // kiểm tra task_code 
        $taskCodeExists = Task::where('task_code', $request->task_code)
            ->where('id', '!=', $request->task_id)
            ->exists();
            
        if ($taskCodeExists) {
            return redirect()->back()->with([
                'message' => 'Mã công việc đã tồn tại',
                'alert-type' => 'error'
            ]);
        }

        if ($request->startDate < $project->startDate) {
            return redirect()->back()->with([
                'message' => 'Ngày bắt đầu công việc không được trước ngày bắt đầu của dự án',
                'alert-type' => 'error'
            ]);
        }

        $startDate = \Carbon\Carbon::parse($request->startDate);
        $endDate = \Carbon\Carbon::parse($request->endDate);
        $duration = $endDate->diffInDays($startDate);

        $task = Task::findOrFail($request->task_id);

        $task->task_name = $request->task_name;
        $task->task_code = $request->task_code;
        $task->startDate = $startDate->format('Y-m-d');
        $task->endDate = $endDate->format('Y-m-d');
        $task->duration = $duration;
        $task->progress = $request->progress;
        $task->status = $request->status;
        


        
        if ($request->filled('note')) {
            $task->description = $request->note;
        }
        if($request->progress == 100)
            $task->status = 1;
        elseif($request->progress < 100)
            $task->status = 0;

        if($task->userID != $request->userID){
            $supervisor = User::find($request->userID);
            $project = Project::find($request->projectID);
            $userOld = User::find($task->userID);
            $currentDate = Carbon::today();
            $content = 'Bạn được phân công phụ trách công việc ' . $task->task_name . ' có mã công việc ' . $task->task_code . ' của dự án '. $project->projectName .' mã ' . $project->projectCode;
            $notificate = Notification::create([
                'title' => 'Việc làm',
                'content'   => $content,
            ]);
            NotificationUser::create([
                'user_id' => $supervisor->id,
                'notification_id' => $notificate->id,
                'is_read' => 0, // Mặc định là chưa đọc
            ]);
            
            $taskWords = TaskWork::where('task_id',$task->id)->where('division_id',$userOld->divisionID)->get();
            foreach($taskWords as $work){
                $work->update([
                    'out_work' => $currentDate,
                    'is_work'  => 1,
                ]);

            }
            TaskWork::create([
                'task_id'   => $task->id,
                'division_id'    => $supervisor->divisionID,
                'at_work'   => $currentDate	
            ]); 




        }
        $task->userID = $request->userID;
        $task->save();

        

        // Cập nhật progress và status của project
        $allTasks = Task::where('projectID', $project->id)->get();
        $totalWeightedProgress = 0;
        $totalWeight = 0;

        foreach ($allTasks as $projectTask) {
            $taskWeight = max(1, \Carbon\Carbon::parse($projectTask->endDate)
                ->diffInDays(\Carbon\Carbon::parse($projectTask->startDate)));
            
            $totalWeightedProgress += ($projectTask->progress * $taskWeight);
            $totalWeight += $taskWeight;
        }

        if ($totalWeight > 0) {
            $project->progress = round($totalWeightedProgress / $totalWeight);
        }

        $currentDate = \Carbon\Carbon::now();
        if ($project->endDate < $currentDate ) {
            $project->status = 3; // Quá hạn

            
            $content = 'Dự án ' . $project->projectName .' mã ' . $project->projectCode . ' Đang chậm tiến độ';
            
            $supervisors = User::all();
            
            $notificate = Notification::create([
                'title' => 'Chậm tiến độ dự án',
                'content'   => $content,
            ]);
            foreach($supervisors as $supervisor){
                if($supervisor->role === "admin" || $supervisor->id == $project->userID)
                NotificationUser::create([
                    'user_id' => $supervisor->id,
                    'notification_id' => $notificate->id,
                    'is_read' => 0, // Mặc định là chưa đọc
                ]);
            }

        } elseif ($project->progress == 100) {
            $project->status = 1; // Đã hoàn thành
        }

        $project->save();
        DB::commit();


        
        return redirect()->back()->with([
            'message' => 'Công việc đã được cập nhật thành công',
            'alert-type' => 'success'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()->back()->with([
            'message' => 'Có lỗi xảy ra khi chỉnh sửa công việc: ' . $e->getMessage(),
            'alert-type' => 'error'
        ]);
    }
}
    public function lockTask($id) {
        
        $currentDate = now();
        $task = Task::find($id);
        if($task->status == 0 || $task->status == 1 || $task->status == 2){
            $task->status = 3;
            $task->save();
            $notification = array(
                'message' => 'công việc đã tạm dừng',
                'alert-type' => 'success'
            );
        }elseif($task->status == 3){
            if($task->progress == 100){
                $task->status = 1;
                $task->save();
            }elseif($task->endDate < $currentDate){
                $task->status = 2;
                $task->save();
            
            }else{
                $task->status = 0;
                $task->save();
            }
            
            $notification = array(
                'message' => 'công việc đã mở lại',
                'alert-type' => 'success'
            );


        }
        return redirect()->back()->with($notification);

        
    }
    public function toggleStar($id)
    {
        $task = Task::find($id);

        if ($task) {
            // Đảo ngược trạng thái status giữa 0 và 1
            $task->star = $task->star == 1 ? 0 : 1;
            $task->save();

            
        }

        return redirect()->back();
    }

    public function import(Request $request)
    {
        // Validate file và projectID
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
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
            // Gọi import và truyền projectID vào
            $file = $request->file('file');

            Log::info('File được tải lên: ' . $file->getClientOriginalName());
            if ($request->hasFile('file')) {
                \Log::info('File name: ' . $request->file('file')->getClientOriginalName());
            } else {
                \Log::error('Không tìm thấy file.');
            }
            
            Excel::import(new TasksImport($request->projectID), $request->file('file'));

            $notification = array(
                'message' => 'Đã Thêm thành công',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);        
        } catch (\Exception $e) {
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
