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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->integer('survey_id');
            $table->integer('student_id')->nullable(); // nếu cần
            $table->string('ma_sv')->nullable();
            $table->string('ho_ten')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->json('student_info')->nullable(); // tùy chọn: chứa phần info còn lại
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
