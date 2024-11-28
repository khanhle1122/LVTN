<?php

namespace App\Imports;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationUser;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class TasksImport implements ToCollection, WithHeadingRow
{
    private $projectID;
    private $projectStartDate;
    private $taskMap = []; // Lưu mapping giữa task_code và id

    public function __construct($projectID)
    {
        $this->projectID = $projectID;

        // Lấy thông tin dự án và lưu startDate
        $project = Project::findOrFail($projectID);
        $this->projectStartDate = $project->startDate;
    }

    public function collection(Collection $rows)
    {
        // Bước 1: Tạo tất cả các task mà không gán parentID
        foreach ($rows as $row) {
            // Chuyển đổi ngày từ số Excel sang định dạng YYYY-MM-DD
            $startDate = $this->convertExcelDate($row['startdate']);
            $endDate = $this->convertExcelDate($row['enddate']);

            // Kiểm tra startDate của task không được trước startDate của dự án
            if (Carbon::parse($startDate)->lt(Carbon::parse($this->projectStartDate))) {
                throw ValidationException::withMessages([
                    'startdate' => "Ngày bắt đầu của công việc ({$startDate}) không được trước ngày bắt đầu của dự án ({$this->projectStartDate}).",
                ]);
            }

            // Tìm userID từ usercode
            $userID = null;
            if (!empty($row['usercode'])) {
                $user = User::where('usercode', $row['usercode'])->first();
                if ($user) {
                    $userID = $user->id;
                } else {
                    throw ValidationException::withMessages([
                        'usercode' => "Không tìm thấy user với usercode ({$row['usercode']}).",
                    ]);
                }
            }

            // Tạo task
            $task = Task::create([
                'task_name' => $row['task_name'],
                'task_code' => $row['task_code'],
                'note'      => $row['note'],
                'startDate' => $startDate,
                'endDate'   => $endDate,
                'duration'  => $row['duration'],
                'status'    => $row['status'] ?? 0,
                'star'      => $row['star'] ?? 0,
                'progress'  => $row['progress'] ?? 0,
                'budget'    => $row['budget'],
                'parentID'  => null, // Tạm thời để null
                'userID'    => $userID,
                'projectID' => $this->projectID,
            ]);

            if ($task->userID) {
                $supervisor = User::find($task->userID);
                $project = Project::find($this->projectID);
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
                        $users = User::where('divisionID',$supervisor->divisionID)->get();
                        foreach($users as $user){
                            NotificationUser::create([
                                'user_id' => $user->id,
                                'notification_id' => $notificate->id,
                                'is_read' => 0, // Mặc định là chưa đọc
                            ]);
                        }
                    }


                }
            }
            
            // Lưu task_code và id để sử dụng cho việc gán parentID sau này
            $this->taskMap[$row['task_code']] = $task->id;
        }

        // Bước 2: Cập nhật parentID cho các task
        foreach ($rows as $row) {
            if (!empty($row['parentcode'])) {
                $parentID = $this->taskMap[$row['parentcode']] ?? null;
        
                if ($parentID) {
                    // Cập nhật parentID cho task hiện tại
                    $taskID = $this->taskMap[$row['task_code']];
                    Task::where('id', $taskID)->update(['parentID' => $parentID]);
                } else {
                    throw ValidationException::withMessages([
                        'parentcode' => "Không tìm thấy task cha với parentcode ({$row['parentcode']}).",
                    ]);
                }
            } else {
                // Nếu parentcode trống, gán parentID là 0
                $taskID = $this->taskMap[$row['task_code']];
                Task::where('id', $taskID)->update(['parentID' => 0]);
            }
        }
        
    }

    private function convertExcelDate($excelDate)
    {
        // Nếu giá trị không phải số, trả về nguyên bản
        if (!is_numeric($excelDate)) {
            return $excelDate;
        }

        // Chuyển đổi từ số Excel thành ngày
        return Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($excelDate - 2)->format('Y-m-d');
    }
}
