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
        Schema::create('taskworkings', function (Blueprint $table) {
            $table->id(); // Tự động tạo cột khóa chính 'id'
            $table->unsignedBigInteger('division_id'); // Khóa ngoại đến bảng users
            $table->unsignedBigInteger('task_id'); // Khóa ngoại đến bảng notifications
            
            $table->integer('is_work')->default(0); // Trạng thái đã đọc
            $table->date('at_work');
            $table->date('out_work')->nullale();
            $table->timestamps(); // Tự động tạo 'created_at' và 'updated_at'

            // Tạo khóa ngoại
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taskworkings');

    }
};
