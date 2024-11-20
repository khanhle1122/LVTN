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
        Schema::create('coats',function (Blueprint $table){
            $table->id();
            $table->string('hangmuc',255);
            $table->string('description',1000);
            $table->string('estimated_cost',255);
            $table->string('actual_cost',255)->nullable();
            $table->string('note',255)->nullable();
            $table->unsignedBigInteger('projectID'); // Khóa ngoại tham chiếu đến bảng project
            // Định nghĩa khóa ngoại tham chiếu đến bảng project
            $table->foreign('projectID')->references('id')->on('projects');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coats');
    }
};
