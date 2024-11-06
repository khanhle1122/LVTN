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
        Schema::create('files',function (Blueprint $table){
            $table->id();
            $table->string('fileName',255);
            $table->string('filePath',255);
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('documentID'); // Khóa ngoại tham chiếu đến bảng project
            
            // Định nghĩa khóa ngoại tham chiếu đến bảng project
            $table->foreign('documentID')->references('id')->on('documents');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
