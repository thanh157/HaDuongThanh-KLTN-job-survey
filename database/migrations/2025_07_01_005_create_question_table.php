<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');           // Thuộc khảo sát nào
            $table->string('question_text');                   // Nội dung câu hỏi
            $table->enum('type', ['single', 'multiple']);      // Loại câu hỏi
            $table->json('options')->nullable();                   // Mảng lựa chọn dưới dạng JSON

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('question');
    }
};
