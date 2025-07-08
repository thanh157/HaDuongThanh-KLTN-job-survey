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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('sso_id')->index();
            $table->string('full_name')->nullable();
            $table->string('code')->nullable();
            $table->text('access_token')->nullable();
            $table->string('remember_token')->nullable();
            $table->json('user_data')->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable()->index();
            $table->string('role')->nullable();
            $table->string('status')->default();
            $table->string('type')->default();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
