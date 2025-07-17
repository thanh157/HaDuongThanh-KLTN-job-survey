<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumni_contact_surveys', function (Blueprint $table) {
            $table->id();
            $table->integer('survey_batch_id')->nullable();

            // Thông tin sinh viên
            $table->string('student_code')->unique(); // Mã SV
            $table->string('full_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('course')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();

            // Thông tin liên hệ cá nhân
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();

            // Thông tin cơ quan công tác
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_contact_surveys');
    }
};
