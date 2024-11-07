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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('expertise');
            $table->string('address'); // Địa chỉ
            $table->string('phone', 11); // Số điện thoại (11 ký tự)
            $table->string('usercode')->unique(); // Tên đăng nhập (cần phải unique)
            $table->string('role', 50);

            $table->unsignedBigInteger('divisionID'); 
            $table->foreign('divisionID')->references('id')->on('divisions'); //khoá ngoại tới bảng phân công

            $table->integer('status')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
