<?php
namespace App\Imports;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\TaskWork;

class TasksImport implements ToModel, WithStartRow
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

    public function model(array $row)
    {
        // Chuyển đổi ngày từ số Excel sang định dạng YYYY-MM-DD
        $startDate = $this->convertExcelDate($row[3]); // Cột startDate
        $endDate = $this->convertExcelDate($row[4]); // Cột endDate

        // Kiểm tra startDate của task không được trước startDate của dự án
        if (Carbon::parse($startDate)->lt(Carbon::parse($this->projectStartDate))) {
            throw ValidationException::withMessages([
                'startdate' => "Ngày bắt đầu của công việc ({$startDate}) không được trước ngày bắt đầu của dự án ({$this->projectStartDate}).",
            ]);
        }

        $existingTask = Task::where('task_code', $row[0])->first(); // Cột task_code
        if ($existingTask) {
            throw ValidationException::withMessages([
                'task_code' => "Mã công việc ({$row[0]}) đã tồn tại.",
            ]);
        }

        // Tìm userID từ usercode
        $userID = null;
        if (!empty($row[7])) { // Cột usercode
            $user = User::where('usercode', $row[7])->first();
            if ($user) {
                $userID = $user->id;
            } else {
                throw ValidationException::withMessages([
                    'usercode' => "Không tìm thấy user với usercode ({$row[7]}).",
                ]);
            }
        }

        // Tạo task
        $task = Task::create([
            'task_name' => $row[1], // Cột task_name
            'task_code' => $row[0], // Cột task_code
            'note'      => $row[2], // Cột note
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'duration'  => $row[5], // Cột duration
           
            'parentID'  => null, // Tạm thời để null
            'userID'    => $userID,
            'projectID' => $this->projectID,
        ]);

        if ($task->userID) {
            $supervisor = User::find($task->userID);
            $project = Project::find($this->projectID);
            $currentDate = Carbon::today();

            if ($supervisor) {

                TaskWork::create([
                    'task_id'   => $task->id,
                    'division_id'    => $supervisor->divisionID,
                    'at_work'   => $currentDate    
                ]);

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
        $this->taskMap[$row[0]] = $task->id; // Lưu mapping task_code => task_id
        if (!empty($row[6])) {
            $parentID = $this->taskMap[$row[6]] ?? null;
    
            if ($parentID) {
                // Cập nhật parentID cho task hiện tại
                Task::where('id', $task->id)->update(['parentID' => $parentID]);
            } else {
                throw ValidationException::withMessages([
                    'parentcode' => "Không tìm thấy task cha với parentcode ({$row['parentcode']}).",
                ]);
            }
        } else {
            // Nếu parentcode trống, gán parentID là 0
            Task::where('id', $task->id)->update(['parentID' => 0]);
        }
        return $task; // Trả về model Task
    }

    // Phương thức này xác định dòng bắt đầu của dữ liệu (dòng 2 nếu có header)
    public function startRow(): int
    {
        return 2; // Dòng đầu tiên chứa header
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
