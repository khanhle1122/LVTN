<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Lấy tất cả usercode từ file Excel
        $usercodes = $rows->pluck('usercode')->toArray();
        
        // Kiểm tra usercode trùng lặp trong file Excel
        $duplicateUsercodes = array_diff_assoc($usercodes, array_unique($usercodes));
        if (!empty($duplicateUsercodes)) {
            throw new \Exception('Có usercode bị trùng lặp trong file: ' . implode(', ', $duplicateUsercodes));
        }

        // Kiểm tra usercode đã tồn tại trong database
        $existingUsercodes = User::whereIn('usercode', $usercodes)->pluck('usercode')->toArray();
        if (!empty($existingUsercodes)) {
            throw new \Exception('Các usercode sau đã tồn tại trong hệ thống: ' . implode(', ', $existingUsercodes));
        }

        // Nếu không có lỗi, tiến hành import
        foreach ($rows as $row) {
            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'expertise' => $row['expertise'],
                'password' => Hash::make($row['password']),
                'address' => $row['address'],
                'status_division' => $row['status_division'] ?? 0,
                'phone' => $row['phone'],
                'usercode' => $row['usercode'],
                'role' => $row['role'],
                'divisionID' => $row['divisionid'] ?? null,
                'status' => $row['status'] ?? 0,
            ]);
        }
    }
}