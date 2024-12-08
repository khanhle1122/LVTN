<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\User;
use App\Models\Client;
use App\Models\Document;
use App\Models\WorkingProject;
use App\Models\Notification;
use App\Models\NotificationUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProjectsImport implements ToModel, WithStartRow
{
    // Xác định bắt đầu từ dòng thứ 2 (dòng đầu tiên là tiêu đề)
    public function startRow(): int
    {
        return 2; // Dòng đầu tiên (dòng tiêu đề) sẽ bị bỏ qua
    }

    public function model(array $row)
    {
        // Chuyển đổi giá trị ngày Excel thành ngày hợp lệ
        $startDate = $this->convertExcelDateToDate($row[5]);
        $endDate = $this->convertExcelDateToDate($row[6]);

        // Kiểm tra lỗi: startDate không được lớn hơn endDate
        if ($startDate->gt($endDate)) {
            throw ValidationException::withMessages([
                'startdate' => "Ngày bắt đầu ({$row[5]}) không được lớn hơn ngày kết thúc ({$row[6]}).",
            ]);
        }

        // Kiểm tra lỗi: project_code không được trùng nhau
        $existingProject = Project::where('projectCode', $row[1])->first();
        if ($existingProject) {
            throw ValidationException::withMessages([
                'projectcode' => "Mã dự án ({$row[1]}) đã tồn tại.",
            ]);
        }

        // Kiểm tra lỗi: không tìm thấy chủ đầu tư (client)
        $existingClient = Client::where('id', $row[9])->first();
        if (!$existingClient) {
            throw ValidationException::withMessages([
                'clientid' => "Không tìm thấy chủ đầu tư cho dự án ({$row[0]}).",
            ]);
        }

        // Kiểm tra sự tồn tại của giám sát viên (userID) nếu có
        $userID = null;
        if (!empty($row[10])) {
            $user = User::where('usercode', $row[10])->first();
            if ($user) {
                $userID = $user->id;
            } else {
                throw ValidationException::withMessages([
                    'usercode' => "Không tìm thấy user với usercode ({$row[10]}).",
                ]);
            }
        }

        // Tạo project mới
        $project = Project::create([
            'projectName' => $row[0],
            'projectCode' => $row[1],
            'description' => $row[2] ?? null,
            'type'        => $row[3] ?? null,
            'address'     => $row[4] ?? null,
            'startDate'   => $startDate,
            'endDate'     => $endDate,
            'level'       => $row[7] ?? null,
            'budget'      => $row[8] ?? null,
            'clientID'    => $row[9] ?? null,
            'userID'      => $userID,
        ]);

        $documentName = $project->projectCode.'_'.$project->projectName;
    
        Document::create([
            'documentName' => $documentName,
            'projectID' => $project->id,
            'doPath'    => 'public/uploads/'. $documentName,
        ]);

        $notification = array(
            'message' => 'Dự án đã được thêm',
            'alert-type' => 'success'
        );

        // Gửi thông báo tới người giám sát (userID là giám sát viên)
        if ($project->userID) {
            WorkingProject::create([
                'user_id'   => $project->userID,
                'project_id'=> $project->id,
                'at_work'   => $project->created_at    
            ]);

            $supervisor = User::find($project->userID);

            if ($supervisor) {
                // Tạo thông báo
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
        }
    }

    // Hàm chuyển đổi số ngày Excel thành ngày thực tế
    private function convertExcelDateToDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            // Chuyển số ngày Excel thành ngày hợp lệ
            return Carbon::createFromFormat('Y-m-d', Carbon::parse('1900-01-01')->addDays($excelDate - 2)->toDateString());
        }

        return Carbon::parse($excelDate);  // Nếu không phải là số, chuyển thẳng sang Carbon
    }
}
