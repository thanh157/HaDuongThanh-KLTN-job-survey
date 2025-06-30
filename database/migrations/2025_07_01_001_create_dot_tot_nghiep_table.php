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
        Schema::create('dot_tot_nghiep', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name')->index()->nullable();
            $table->string('certification')->index()->nullable();
            $table->date('certification_date')->index()->nullable();
            $table->integer('school_year')->nullable();
            $table->integer('faculty_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dot_tot_nghiep');
    }
};
