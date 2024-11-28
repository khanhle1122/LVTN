<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\User;
use App\Models\Client;
use App\Models\Document;
use App\Models\WorkingProject;
use App\Models\Notification;
use App\Models\NotificationUser;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ProjectsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Kiểm tra lỗi: startDate không được lớn hơn endDate
            $startDate = Carbon::parse($row['startdate']);
            $endDate = Carbon::parse($row['enddate']);

            if ($startDate->gt($endDate)) {
                throw ValidationException::withMessages([
                    'startdate' => "Ngày bắt đầu ({$row['startdate']}) không được lớn hơn ngày kết thúc ({$row['enddate']}).",
                ]);
            }

            // Kiểm tra lỗi: project_code không được trùng nhau
            $existingProject = Project::where('projectCode', $row['projectcode'])->first();
            if ($existingProject) {
                throw ValidationException::withMessages([
                    'projectcode' => "Mã dự án ({$row['projectcode']}) đã tồn tại.",
                ]);
            }
            $existingClient = Client::where('id', $row['clientid'])->first();
            if (!$existingClient) {
                throw ValidationException::withMessages([
                    'clientid' => "Không tìm thấy chủ đầu tư cho dự án ({$row['projectname']}).",
                ]);
            }
            // Tạo project mới
            $project = Project::create([
                'projectName' => $row['projectname'],
                'projectCode' => $row['projectcode'],
                'description' => $row['description'] ?? null,
                'type'        => $row['type'] ?? null,
                'address'     => $row['address'] ?? null,
                'startDate'   => $row['startdate'],
                'endDate'     => $row['enddate'],
                'status'      => $row['status'] ?? 0,
                'level'       => $row['level'] ?? null,
                'budget'      => $row['budget'] ?? null,
                'clientID'    => $row['clientid'] ?? null,
                'progress'    => $row['progress'] ?? 0,
                'toggleStar'  => $row['togglestar'] ?? 0,
                'userID'      => $row['userid'] ?? null,
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
                    'project_id'    => $project->id,
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
    }
}
