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
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); // Tự động tạo cột khóa chính 'id'
            $table->string('comment');
            $table->integer('totalCoat');
            $table->boolean('is_pass');
            $table->unsignedBigInteger('user_id'); // Khóa ngoại đến bảng users
            $table->unsignedBigInteger('project_id'); // Khóa ngoại đến bảng notifications
            
            
            $table->timestamps(); // Tự động tạo 'created_at' và 'updated_at'

            // Tạo khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');

    }
};
