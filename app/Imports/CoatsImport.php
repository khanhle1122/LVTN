<?php

namespace App\Imports;

use App\Models\Coat;
use App\Models\Project;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Collection;

class CoatsImport implements ToCollection, WithHeadingRow
{
    private $projectID;
    public function __construct($projectID)
    {
        $this->projectID = $projectID;

       
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Kiểm tra dữ liệu đầu vào (nếu cần thiết)
            
        
            // Tạo bản ghi mới trong bảng coats
            Coat::create([
                'hangmuc' => $row['hangmuc'],
                'description' => $row['description'],
                'estimated_cost' => $row['estimated_cost'] ?? null, // Mặc định null nếu không có
                'note' => $row['note'] ?? null, // Mặc định null nếu không có
                'projectID' => $this->projectID, // Mặc định null nếu không có
            ]);
        }
    }
}
