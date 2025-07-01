<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('graduation_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code')->unique(); // mã sinh viên
            $table->string('full_name');
            $table->enum('gender', ['Nam', 'Nữ']);
            $table->foreignId('training_industry_id')->constrained('training_industries')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
