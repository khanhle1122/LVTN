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
        $show= 0 ;
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
        return view('admin.task', compact('project','documents','tasks','show'));
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
    
        $show = 0;
        $notification = array(
            'message' => 'Thư mục và file đã được thêm ',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification,$show);


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
        $updatePartent = Task::where('parentID',$request->parentID)->get();
        // Trước khi tạo task mới, kiểm tra và điều chỉnh thời gian nếu cần
        if ($request->change == 'update') {
            

            // Tìm task ngay trước task mới
            $previousTask = Task::where('projectID', $request->projectID)
                            ->where('endDate', '<', $request->startDate)
                            ->orderBy('endDate', 'desc')
                            ->first();

            // Nếu có task trước đó và không liền kề
            if ($previousTask) {
                $previousEndDate = \Carbon\Carbon::parse($previousTask->endDate);
                // Thêm 1 ngày vào endDate của task trước
                if ($previousEndDate->addDays()->format('Y-m-d') != $startDate->format('Y-m-d')) {
                    // Điều chỉnh startDate của task mới, thêm 2 ngày từ task trước
                    $startDate = $previousEndDate->addDays();
                    $endDate = (clone $startDate)->addDays($duration);
                }
            }
        }

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
            'budget' => $request->budget,
            'duration' => $duration,
        ]);

        if ($request->change == 'update') {
            // sửa parent 
            foreach($updatePartent as $item){
                $item->parentID = $task->id ;
                $item->save();
            }
            // Lấy tất cả các task sau task mới
            $laterTasks = Task::where('projectID', $request->projectID)
                            ->where('startDate', '>=', $startDate->format('Y-m-d'))
                            ->where('id', '!=', $task->id)
                            ->orderBy('startDate', 'asc')
                            ->get();

            $previousEndDate = $endDate;

            foreach ($laterTasks as $laterTask) {
                $taskStartDate = \Carbon\Carbon::parse($laterTask->startDate);
                $taskEndDate = \Carbon\Carbon::parse($laterTask->endDate);
                $taskDuration = $taskEndDate->diffInDays($taskStartDate);

                // Cập nhật ngày bắt đầu là 2 ngày sau ngày kết thúc của task trước
                $newStartDate = $previousEndDate->addDays();
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

            // Kiểm tra và cập nhật thời gian dự án nếu cần
            $this->updateProjectDuration($request->projectID);
        }
        $show = 0;
        $notification = array(
            'message' => 'Công việc đã được thêm ',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification,$show);

    }
   
    // Hàm cập nhật thời gian dự án
    private function updateProjectDuration($projectID)
    {
        $project = Project::find($projectID);
        if ($project) {
            // Lấy task có startDate sớm nhất và endDate muộn nhất
            $firstTask = Task::where('projectID', $projectID)
                            ->orderBy('startDate', 'asc')
                            ->first();
            $lastTask = Task::where('projectID', $projectID)
                        ->orderBy('endDate', 'desc')
                        ->first();

            if ($firstTask && $lastTask) {
                $project->update([
                    'startDate' => $firstTask->startDate,
                    'endDate' => $lastTask->endDate,
                    'duration' => \Carbon\Carbon::parse($lastTask->endDate)
                        ->diffInDays(\Carbon\Carbon::parse($firstTask->startDate))
                ]);
            }
        }
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

            if ($project) {
                // Lấy tất cả các task của project
                $allTasks = Task::where('projectID', $project->id)->get();
                $totalProgress = 0;
                $taskCount = count($allTasks);
    
                // Tính tổng progress của tất cả các task
                foreach ($allTasks as $projectTask) {
                    $totalProgress += $projectTask->progress;
                }
    
                // Cập nhật progress của project
                $project->progress = $taskCount > 0 ? round($totalProgress / $taskCount) : 0;
    
                // Cập nhật status của project
                if ($project->endDate < $currentDate) {
                    // Nếu đã quá thời hạn
                    $project->status = 3; // Quá hạn
                } elseif ($project->progress == 100) {
                    // Nếu hoàn thành 100% và chưa quá hạn
                    $project->status = 1; // Đã hoàn thành
                }
    
                $project->save();
            }
    
            $show = 1;
            $notification = [
                'message' => 'Tiến độ đã được cập nhật',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notification, $show);
        }
    }

    public function editTask(Request $request)
{
    $request->validate([
        'task_name' => 'required|string',
        'endDate' => 'required|date',
        'startDate' => 'required|date',
        'projectID' => 'required',
        'userID' => 'required',
        'parentID' => 'required',
        'task_id' => 'required'
    ]);

    try {
        DB::beginTransaction();

        $startDate = \Carbon\Carbon::parse($request->startDate);
        $endDate = \Carbon\Carbon::parse($request->endDate);
        $duration = $endDate->diffInDays($startDate);
        $updateParent = Task::where('parentID', $request->parentID)->get();

        // Lấy thông tin task cũ trước khi update
        $oldTask = Task::findOrFail($request->task_id);
        $oldStartDate = \Carbon\Carbon::parse($oldTask->startDate);
        $oldEndDate = \Carbon\Carbon::parse($oldTask->endDate);
        $oldDuration = $oldEndDate->diffInDays($oldStartDate);

        if ($request->change == 'update') {
            // Tìm task ngay trước task mới
            $previousTask = Task::where('projectID', $request->projectID)
                            ->where('endDate', '<', $request->startDate)
                            ->orderBy('endDate', 'desc')
                            ->first();

            // Nếu có task trước đó và không liền kề
            if ($previousTask) {
                $previousEndDate = \Carbon\Carbon::parse($previousTask->endDate);
                if ($previousEndDate->addDays()->format('Y-m-d') != $startDate->format('Y-m-d')) {
                    $startDate = $previousEndDate->addDays();
                    $endDate = (clone $startDate)->addDays($duration);
                }
            }
        }

        $task = Task::findOrFail($request->task_id);

        $task->task_name = $request->task_name;
        $task->task_code = $request->task_code;
        $task->startDate = $startDate->format('Y-m-d');
        $task->endDate = $endDate->format('Y-m-d');
        $task->duration = $duration;
        $task->parentID = $request->parentID;
        $task->progress = $request->progress;
        $task->userID = $request->userID;

        if ($request->filled('budget')) {
            $task->budget = $request->budget;
        }
        if ($request->filled('note')) {
            $task->description = $request->input('note');
        }

        $task->save();

        if ($request->change == 'update') {
            // Sửa parent
            foreach ($updateParent as $item) {
                $item->parentID = $task->id;
                $item->save();
            }

            // Lấy tất cả các task sau task mới
            $laterTasks = Task::where('projectID', $request->projectID)
                            ->where('startDate', '>=', $startDate->format('Y-m-d'))
                            ->where('id', '!=', $task->id)
                            ->orderBy('startDate', 'asc')
                            ->get();

            $previousEndDate = $endDate;
            $timeDifference = $duration - $oldDuration;

            foreach ($laterTasks as $laterTask) {
                $taskStartDate = \Carbon\Carbon::parse($laterTask->startDate);
                $taskEndDate = \Carbon\Carbon::parse($laterTask->endDate);
                $taskDuration = $taskEndDate->diffInDays($taskStartDate);

                // Điều chỉnh thời gian dựa trên sự thay đổi của task gốc
                $newStartDate = $previousEndDate->addDays();
                
                // Nếu thời gian task gốc tăng
                if ($timeDifference > 0) {
                    $newEndDate = (clone $newStartDate)->addDays($taskDuration + $timeDifference);
                } 
                // Nếu thời gian task gốc giảm
                else {
                    $newEndDate = (clone $newStartDate)->addDays(max(0, $taskDuration + $timeDifference));
                }

                // Cập nhật task
                $laterTask->update([
                    'startDate' => $newStartDate->format('Y-m-d'),
                    'endDate' => $newEndDate->format('Y-m-d'),
                    'duration' => max(0, $newEndDate->diffInDays($newStartDate))
                ]);

                $previousEndDate = $newEndDate;
            }
        }

        // Cập nhật progress và status của project
        $project = Project::findOrFail($request->projectID);
        $allTasks = Task::where('projectID', $project->id)->get();
        $totalWeightedProgress = 0;
        $totalWeight = 0;

        foreach ($allTasks as $projectTask) {
            // Tính trọng số dựa trên thời gian của task
            $taskWeight = \Carbon\Carbon::parse($projectTask->endDate)
                ->diffInDays(\Carbon\Carbon::parse($projectTask->startDate));
            
            // Đảm bảo weight tối thiểu là 1
            $taskWeight = max(1, $taskWeight);
            
            $totalWeightedProgress += ($projectTask->progress * $taskWeight);
            $totalWeight += $taskWeight;
        }

        // Cập nhật progress của project
        if ($totalWeight > 0) {
            $project->progress = round($totalWeightedProgress / $totalWeight);
        } else {
            $project->progress = 0;
        }

        // Cập nhật status của project
        $currentDate = \Carbon\Carbon::now();
        if ($project->endDate < $currentDate && $project->progress < 100) {
            $project->status = 3; // Quá hạn
        } elseif ($project->progress == 100) {
            $project->status = 1; // Đã hoàn thành
        } 

        $project->save();

        // Kiểm tra và cập nhật thời gian dự án nếu cần
        $this->updateProjectDuration($request->projectID);

        DB::commit();

        return redirect()->back()->with([
            'message' => 'Công việc đã được chỉnh sửa thành công',
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
public function deleteTask(Request $request) {
    $request->validate([
        'task_id' => 'required',
    ]);

    try {
        DB::beginTransaction();
        
        // Tìm task cần xóa
        $task = Task::findOrFail($request->task_id);
        $projectID = $task->projectID;
        $project = Project::find($projectID);
        
        if (!$project) {
            throw new \Exception('Không tìm thấy dự án');
        }

        // Lưu thông tin thời gian của task bị xóa để điều chỉnh các task sau
        $taskStartDate = \Carbon\Carbon::parse($task->startDate);
        $taskEndDate = \Carbon\Carbon::parse($task->endDate);
        $taskDuration = $taskEndDate->diffInDays($taskStartDate);
        
        // Xử lý task con
        $childTasks = Task::where('parentID', $task->id)->get();
        if ($childTasks->count() > 0) {
            foreach ($childTasks as $childTask) {
                $childTask->update(['parentID' => $task->parentID]);
            }
        }
        
        // Tìm các task liên quan
        $laterTasks = Task::where('projectID', $projectID)
            ->where('startDate', '>', $task->endDate)
            ->orderBy('startDate', 'asc')
            ->get();
            
        $previousTask = Task::where('projectID', $projectID)
            ->where('endDate', '<', $task->startDate)
            ->orderBy('endDate', 'desc')
            ->first();
            
        // Xóa task
        $task->delete();

        // Cập nhật progress của project
        $allTasks = Task::where('projectID', $project->id)->get();
        $totalWeightedProgress = 0;
        $totalWeight = 0;

        foreach ($allTasks as $projectTask) {
            // Tính trọng số dựa trên độ phức tạp hoặc thời gian của task
            $taskWeight = \Carbon\Carbon::parse($projectTask->endDate)
                ->diffInDays(\Carbon\Carbon::parse($projectTask->startDate));
            
            // Đảm bảo weight tối thiểu là 1
            $taskWeight = max(1, $taskWeight);
            
            $totalWeightedProgress += ($projectTask->progress * $taskWeight);
            $totalWeight += $taskWeight;
        }

        // Cập nhật progress và status của project
        $currentDate = \Carbon\Carbon::now();
        if ($totalWeight > 0) {
            $project->progress = round($totalWeightedProgress / $totalWeight);
        } else {
            $project->progress = 0;
        }

        // Cập nhật status của project
        if ($project->endDate < $currentDate && $project->progress < 100) {
            $project->status = 3; // Quá hạn
        } elseif ($project->progress == 100) {
            $project->status = 1; // Đã hoàn thành
        } 

        $project->save();

        // Cập nhật thời gian các task sau
        if ($laterTasks->count() > 0) {
            $previousEndDate = $previousTask ? 
                \Carbon\Carbon::parse($previousTask->endDate) : 
                \Carbon\Carbon::parse($laterTasks->first()->startDate)->subDays($taskDuration + 1);
                
            foreach ($laterTasks as $laterTask) {
                $taskDuration = \Carbon\Carbon::parse($laterTask->endDate)
                    ->diffInDays(\Carbon\Carbon::parse($laterTask->startDate));
                    
                $newStartDate = $previousEndDate->copy()->addDay();
                $newEndDate = $newStartDate->copy()->addDays($taskDuration);
                
                $laterTask->update([
                    'startDate' => $newStartDate->format('Y-m-d'),
                    'endDate' => $newEndDate->format('Y-m-d')
                ]);
                
                $previousEndDate = $newEndDate;
            }
        }
        
        // Cập nhật thời gian dự án
        $this->updateProjectDuration($projectID);
        
        DB::commit();
        
        return redirect()->back()->with([
            'message' => 'Công việc đã được xóa thành công',
            'alert-type' => 'success'
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()->back()->with([
            'message' => 'Có lỗi xảy ra khi xóa công việc: ' . $e->getMessage(),
            'alert-type' => 'error'
        ]);
    }
}
    
}
