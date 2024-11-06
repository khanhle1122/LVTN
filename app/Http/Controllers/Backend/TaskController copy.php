<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\File;
use App\Models\Task;
use App\Models\Document;



class TaskController extends Controller
{
    public function viewtask($id) {

        $project = Project::find($id);
        $documents = Document::where('projectID',$id)->get();
        $tasks = Task::where('projectID', $id)
        ->orderBy('startDate', 'asc')
        ->get();
        // Kiểm tra nếu project không tồn tại
        if (!$project) {
            $notification = array(
                'message' => 'dự án không tồn tại',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    
        // Lấy các task liên quan đến project
        // $tasks = Task::where('projectID', $project->id)->get();
    
        // Trả về view với project và tasks
        return view('admin.task', compact('project','documents','tasks'));
    }
    public function listTask() {
        

        return view('admin.list_task');
    }
    

    public function addDo(Request $request){
        $request->validate([
            'files.*' => 'required|file',
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
    

        $notification = array(
            'message' => 'Thư mục và file đã được thêm đã được thêm',
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
        
        return redirect()->back()->with($notification);
        
    }
    public function addTask(Request $request)
{
    $request->validate([
        'task_name' => 'required|string',
        'note' => 'required|string', 
        'endDate' => 'required|date',
        'startDate' => 'required|date',
        'projectID' => 'required',
        'userID' => 'required',
        'parentID' => 'required',
        'budget' => 'required',
        'change' => 'required',
    ]);

    $startDate = \Carbon\Carbon::parse($request->startDate);
    $endDate = \Carbon\Carbon::parse($request->endDate);
    $duration = $endDate->diffInDays($startDate);
    $taskChangeParentIDs = Task::where('parentID',$request->parentID)->get;
    $taskChangeDates = Task::where('parentID','>',$request->parentID)->get;

    // Tạo task mới
    $task = Task::create([
        'task_name' => $request->task_name,
        'task_code' => 'B223',
        'startDate' => $request->startDate,
        'endDate' => $request->endDate,
        'note' => $request->note,
        'parentID' => $request->parentID,
        'projectID' => $request->projectID,
        'userID' => $request->userID,
        'budget' => $request->budget,
        'duration' => $duration,
    ]);
    $taskEndNew = \Carbon\Carbon::parse($task->endDate);
    $taskStartNew = \Carbon\Carbon::parse($task->startDate);


    if ($request->change == 'update') {


        foreach($taskChangeParentIDs as $taskChangeParentID) {
            $taskChangeParentID->parentID = $task->id;


            $newStartDate = $previousEndDate->addDays(2);
            $newEndDate = (clone $newStartDate)->addDays($taskDuration);

            
            $taskChangeParentID->save();
        }
        
        foreach($taskChangeDates as $taskSon){
            foreach($taskChangeDates as $taskParent){
                if($taskSon->parentID == $task->id ){
                    $taskSon->startDate = $taskEndNew ;


                    $taskStartNew = \Carbon\Carbon::parse($taskParent->endDate);


                }
                elseif( $taskSon->parentID == $taskParent->id){

                }


            }
        }


        foreach ($laterTasks as $laterTask) {
            // Parse ngày bắt đầu và kết thúc của task hiện tại
            $taskStartDate = \Carbon\Carbon::parse($laterTask->startDate);
            $taskEndDate = \Carbon\Carbon::parse($laterTask->endDate);
            $taskDuration = $taskEndDate->diffInDays($taskStartDate);

            // Cập nhật ngày bắt đầu là ngày sau ngày kết thúc của task trước
            $newStartDate = $previousEndDate->addDay();
            // Tính ngày kết thúc mới dựa trên duration của task
            $newEndDate = (clone $newStartDate)->addDays($taskDuration);

            // Cập nhật task
            $laterTask->update([
                'startDate' => $newStartDate->format('Y-m-d'),
                'endDate' => $newEndDate->format('Y-m-d')
            ]);

            // Cập nhật previousEndDate cho vòng lặp tiếp theo
            $previousEndDate = $newEndDate;
        }
    }
    $notification = array(
        'message' => 'Công việc đã được thêm',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);

}

    
}
