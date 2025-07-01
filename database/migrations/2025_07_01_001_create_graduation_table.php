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
        Schema::create('graduation', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name')->index()->nullable();
            $table->string('certification')->index()->nullable();
            $table->date('certification_date')->index()->nullable();
            $table->integer('school_year')->nullable();
            $table->integer('student_count')->nullable();
            $table->integer('faculty_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduation');
    }
};
