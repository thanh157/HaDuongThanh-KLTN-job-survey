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
        Schema::create('survey', function (Blueprint $table) {
            $table->id();
            $table->string('title');               // Tiêu đề khảo sát
            $table->text('description')->nullable(); // Mô tả khảo sát
            $table->date('start_time')->nullable();   // Thời gian bắt đầu
            $table->date('end_time')->nullable();     // Thời gian kết thúc
            $table->integer('graduation_id')->nullable(); // Đợt tốt nghiệp (VD: Đợt 1, Đợt 2...)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey');
    }
};
