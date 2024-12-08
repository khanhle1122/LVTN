<?php

namespace App\Imports;

use App\Models\Contractor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow; // Thêm trait này

class ClientsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2; // Dòng đầu tiên (dòng tiêu đề) sẽ bị bỏ qua
    }
    public function model(array $row)
    {
        $existingcontractorcode = Contractor::where('contactorCode', $row[0])->exists();
        if ($existingcontractorcode) {
            throw new \Exception('mã khach hàng "' . $row[0] . '" đã tồn tại trong hệ thống.');
        }
        $existingEmail = Contractor::where('email', $row[2])->exists();
        if ($existingEmail) {
            throw new \Exception('Email "' . $row[2] . '" đã tồn tại trong hệ thống.');
        }

        // Tạo Client với dữ liệu và lưu ảnh đã tải lên
        $contractor = Contractor::create([
            'contactorCode' => $row[0],
            'name' => $row[1], // Giả sử cột tên khách hàng là cột 1
            'email' => $row[2], // Giả sử cột email là cột 2
            'phone' => $row[3], // Giả sử cột số điện thoại là cột 3
            'address' => $row[4], // Giả sử cột địa chỉ là cột 4
        ]);
        

        return $contractor;
    }
}
