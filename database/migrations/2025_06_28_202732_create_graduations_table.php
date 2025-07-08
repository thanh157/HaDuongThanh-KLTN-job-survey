<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('graduation_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code')->unique(); // mã sinh viên
            $table->string('full_name');
            $table->enum('gender', ['Nam', 'Nữ']);
            $table->integer('training_industry_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graduation_students');
    }
};
