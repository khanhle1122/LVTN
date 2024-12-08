<?php
namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow; // Thêm trait này
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithStartRow
{
    // Xác định bắt đầu từ dòng thứ 2 (dòng đầu tiên là tiêu đề)
    public function startRow(): int
    {
        return 2; // Dòng đầu tiên (dòng tiêu đề) sẽ bị bỏ qua
    }

    public function model(array $row)
    {
        // Kiểm tra xem email có trùng trong cơ sở dữ liệu không
        $existingEmail = User::where('email', $row[1])->exists();
        if ($existingEmail) {
            throw new \Exception('Email "' . $row[1] . '" đã tồn tại trong hệ thống.');
        }

        // Kiểm tra xem usercode có trùng trong cơ sở dữ liệu không
        $existingUsercode = User::where('usercode', $row[7])->exists();
        if ($existingUsercode) {
            throw new \Exception('Usercode "' . $row[7] . '" đã tồn tại trong hệ thống.');
        }

        // Trả về một instance của model User với các trường được ánh xạ từ các chỉ số cột
        return new User([
            'name' => $row[0],               // Cột 0: "name"
            'email' => $row[1],              // Cột 1: "email"
            'expertise' => $row[2],          // Cột 2: "expertise"
            'password' => Hash::make($row[3]), // Cột 3: "password"
            'address' => $row[4],            // Cột 4: "address"
            'status_division' => $row[5] ?? 0, // Cột 5: "status_division" (giá trị mặc định là 0)
            'phone' => $row[6],              // Cột 6: "phone"
            'usercode' => $row[7],           // Cột 7: "usercode"
            'role' => $row[8],               // Cột 8: "role"
        ]);
    }
}
