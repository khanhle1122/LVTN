<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Khóa chính tự động tăng
            $table->string('projectName', 255); // Tên dự án
            $table->string('projectCode', 255)->unique(); // Mã dự án
            $table->string('description', 255)->default(); // Mô tả dự án
            $table->string('type', 255); // Mô tả dự án
            $table->date('startDate'); // Ngày bắt đầu
            $table->date('endDate'); // Ngày kết thúc
            $table->integer('status')->default(0); // Trạng thái (giá trị số nguyên)
            $table->string('level', 255); // Cấp độ của dự án
            $table->string('budget');
            $table->integer('progress')->default(0);
            $table->integer('toggleStar')->default(0);
            $table->integer('report_status')->default(0); // Trạng thái (giá trị số nguyên)

            // Định nghĩa khóa ngoại tham chiếu đến bảng clients
            $table->foreignId('userID')->constrained('users')->onDelete('restrict');
            $table->foreignId('clientID') // Thêm khóa ngoại đến bảng clients
                    ->constrained('clients')
                    ->onDelete('restrict');
            // Thêm các cột timestamp (usscreated_at và updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
