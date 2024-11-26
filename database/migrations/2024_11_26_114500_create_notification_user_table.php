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
        Schema::create('notification_user', function (Blueprint $table) {
            $table->id(); // Tự động tạo cột khóa chính 'id'
            $table->unsignedBigInteger('user_id'); // Khóa ngoại đến bảng users
            $table->unsignedBigInteger('notification_id'); // Khóa ngoại đến bảng notifications
            $table->boolean('is_read')->default(false); // Trạng thái đã đọc
            $table->timestamps(); // Tự động tạo 'created_at' và 'updated_at'

            // Tạo khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_user');
    }
};
